# TAPscan v4

This repository contains the source code for the TAPscan v4 website: [tapscan.plantcode.cup.uni-freiburg.de](http://tapscan.plantcode.cup.uni-freiburg.de)


## First time setup

If you would like to run your own copy of TAPscan with your own data, you can follow the following procedure.

### Install dependencies

1. Install Docker on your system according to the [official instructions](https://docs.docker.com/engine/install/)


### Install TAPscan

0. Clone this GitHub repo

1. Configure settings:

```
cp env.example .env  #create a copy of the example env file
# edit .env file as needed
```

2. Start the application for the first time
   -  `make first-run`

This will run the application in docker. Once it has started successfully,  open a new terminal and run the configuration step:

2. Apply configuration:
   - `make configure`
   - **Tip:** this step can be combined with the database population step (see next section) by doing `make configure-and-import` instead (but his will take quite some time)

This may take a few minutes. When everything is ready, the containers will be stopped. From now on, we can control TAPscan directly using the docker compose file.

3. Start TAPscan application
   - `docker-compose up` (or `make run`)

4. View  TAPscan application
   - By default the application will run at `http://0.0.0.0:8000`

5. To stop the application
   - `docker-compose down` (or `make stop`)

**Troubleshooting**

If you encounter permission errors when viewing the website, please set the following permissions on the `public` and `storage` folders:

```
sudo chmod -R a+rwx public storage
```


### Adding Data: Populating the database

The `_data` folder contains all the data used to populate the TAPscan website. Data can be uploaded via the admin panel in the web interface, or via the commandline. For the initial data upload, we recommend using the commandline, because it can take quite some time.

To load the TAPscan v4 data into the database:

1. Start TAPscan
   - `make first-run`
   - wait until TAPscan is running (i.e no more new output in terminal)

2. In a differenct terminal, run the importers
   - `make import-data`
   - This will take quite some time (~30 minutes)
   - You can monitor progress in the first terminal window
   - When it is done, the container will shut down
   - The data that is uploaded in this command is:
     ```
     _data/import-species/species_v4.csv
     _data/import-rules/rules_v81.txt
     _data/import-taps/taps_v4.csv
     _data/import-tapinfo/tapinfo_v4.csv
     _data/import-domains/domains_v4.csv
     ```

3. To upload more data later, first create an admin user
   - navigate to `http://0.0.0.0/register`
   - create an admin account

4. Upload data via the Admin panel.
   - Admin -> Data Upload and follow the instructions

**TIP:** The data upload step can be combined with the first configuration step by using the command `make configure-and-import`


### Configure Web server

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

## Preparing data for upload

Steps to follow to make data ready for inclusion in TAPscan:

### Species informaion
- file format
- example

### Rules
- file format
- example

### TAPs


run TAPscan, and upload the `output.3` result files in the admin panel

TODO: link to tapscan script and/or galaxy tool

### TAP descriptions
- file format
- example



## Debug/dev notes

```
# remove all docker images, containers and volumes if setup goes wrong
./vendor/bin/sail down --rmi all -v
```




