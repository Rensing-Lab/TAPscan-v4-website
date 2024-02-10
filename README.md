![](public/img/TAPscan_logo_v4.png)

# TAPscan v4

This repository contains the source code for the TAPscan v4 website: [tapscan.plantcode.cup.uni-freiburg.de](http://tapscan.plantcode.cup.uni-freiburg.de)

Below you will find some documentation about installation, configuration and data import

1. [First-time setup](#first-time-setup)
2. [Preparing data for upload](#preparing-data-for-upload)
3. [Configuring a web server](#configure-web-server)


TAPscan is written in the [Laravel PHP framework](https://laravel.com/), and everything (application and database) is run in [Docker](https://www.docker.com/) containers.


## First time setup

If you would like to run your own copy of TAPscan with your own data, you can follow the following procedure.

### Install dependencies

1. Install Docker on your system according to the [official instructions](https://docs.docker.com/engine/install/)


### Install TAPscan

1. Clone this GitHub repo
   - `git clone https://github.com/Rensing-Lab/TAPscan-v4-website.git`

2. Edit environment file with your settings:
   - Edit the `.env` file as needed
   - Make sure to change the database password (`'DB_PASSWORD'`)
   - To change the port the TAPscan application runs on (default `8000`), edit the `docker-compose.yml` file (line 12).

3. Apply configuration:
   - `make configure`
   - This may take a few minutes. When everything is ready, the containers will be stopped.

4. Start TAPscan application
   - `docker-compose up` (or `make run`)

5. View  TAPscan application
   - By default the application will run at `http://0.0.0.0:8000`

6. To stop the application
   - `docker-compose down` (or `make stop`)

**Troubleshooting**

If you encounter permission errors when viewing the website, please set the following permissions on the `public` and `storage` folders:

```
sudo chmod -R a+rwx public storage
```


### Adding Data: Populating the database

The `_data` folder contains all the data we used to populate the main [TAPscan website](http://tapscan.plantcode.cup.uni-freiburg.de/).

Data can be uploaded via the admin panel in the TAPscan web interface, or via the commandline. For the initial data upload, we recommend using the commandline, because this step can take quite some time.

To load the TAPscan v4 data from the `_data` folder into the TAPscan database, follow the instructions below. To prepare your own data for upload, see the *"Preparing data for upload"* section.

1. Run the importers
   - `make import-data`
   - This will take quite some time (>1h for the v4 dataset)
   - When it is done, the containers will shut down
   - The data that is uploaded to the database with this command is:
     ```
     _data/import-species/species_v4.csv
     _data/import-rules/rules_v81.txt
     _data/import-taps/taps_v4.csv
     _data/import-tapinfo/tapinfo_v4.csv
     _data/import-domains/domains_v4.csv
     ```
   - To run this importer with different data, simply replace the files mentioned above with your own.

3. To upload more data later, first create an admin user
   - navigate to `http://0.0.0.0:8000/register`
   - create an admin account
   - **Note:** only one account can be made, so make sure to remember your credentials!

4. Now there is an "Admin" section at the top of the page
   - Here you can view (and edit) existing data
   - Or upload additional data files under *Admin -> Data Upload*


**TIP:** The data upload step can be combined with the first configuration step by using the command `make configure-and-import`


### Deleting TAPscan

To throw away your TAPscan images, containers, volumes, you run `make delete`.
This will delete any data in the TAPscan database as well, so use with care!


## Preparing data for upload

Steps to follow to make data ready for inclusion in TAPscan:

### Species informaion
- Format:
	- Semicolon (`;`) separated file
    - 8 columns: `lettercode;Kingiom/supergroup;phylum/clade; supergroup2;order;family;scientific name;NCBI TaxID`
- Example: [TAPscanv4 Species file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-species/species_v4.csv)

### Rules
- Format:
	- Semicolon (`;`) separated file
    - 3 columns: `TAP family;Domain;Rule (should | should not)`
- Example: [TAPscanv4 Rules file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-rules/rules_v81.txt)

### TAPs
- Run the [TAPscan-classify](https://github.com/Rensing-Lab/TAPscan-classify) tool,
- The subfamily classification outputs (`*.output.3`) can be uploaded directly into the TAPscan website
- Format:

- Example: [TAPscanv4 Tap file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tap/taps_v4.csv)

### TAP information
- Format:
  - TAB-separated file
  - With 4 columns: `TAP name [TAB] Description [TAB] "reference1","reference2",.. [TAB] Type (TR|TF|PT)`
  - References can be free-text citations. Preferably with a DOI link.
- Example: [TAPscanv4 TapInfo file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tapinfo/tapinfo_v4.csv)

### Domains file
- Format:
  - Semicolon (`;`) separated file
  - With 2 columns: `Domain;PFAM ID`
  - PFAM IDs start with `PF`, e.g. `PF00249`
- Example: [TAPscanv4 TapInfo file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-domain/domains_v4.csv)



## Configure Web Server

To serve the TAPscan website you need a bit of configuration of a webserver such as Apache or NGINX.

Below is an example nginx configuration:

```
server {
  listen 80 default_server;
  listen [::]:80 default_server;

  root /home/tapscan/TAPscan-v4-website;

  server_name tapscan.plantcode.cup.uni-freiburg.de;

  location / {
    proxy_pass http://0.0.0.0:8000;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection 'upgrade';
    proxy_set_header Host $host;
    proxy_cache_bypass $http_upgrade;
  }
}
```







