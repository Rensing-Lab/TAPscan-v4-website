![](public/img/TAPscan_logo_v4.png)

# TAPscan v4

This repository contains the source code for the TAPscan v4 website: [tapscan.plantcode.cup.uni-freiburg.de](http://tapscan.plantcode.cup.uni-freiburg.de)

Below you will find some documentation about installation, configuration and data import

1. [Data Files](#data-files)  
2. [Installation](#installation)
   - [Install Dependencies](#install-dependencies)
   - [Install TAPscan](#install-tapscan)
   - [Configure web server](#configure-web-server)
   - [Populating the database](#populating-the-database)
   - [Deleting TAPscan](#deleting-tapscan)
3. [Preparing your data for upload](#preparing-data-for-upload)
   - [Sequence Files](#sequence-files)
   - [Species Information](#species-information)
   - [Rules](#rules)
   - [TAPs](#taps)
   - [TAP Information](#tap-information)
   - [Domain Information](#domains-file)
   - [Trees](#trees)


TAPscan is written in the [Laravel PHP framework](https://laravel.com/), and everything (application and database) is run in [Docker](https://www.docker.com/) containers.

## Data Files

The data used within the MAdLand TAPscan v4 website, is available from this repository. The `_data` folder contains the raw and processed data used to configure the website.

The data is organized into a set of subfolders, each subfolder contains a `readme.md` file describing the contents.
 - `import_domain`: contains the domain information, `domains_v4.csv` contains a table with domain names and PFAM domains. For the custom domains we used, the `.hmm` can be found in `import_domain/custom_hmms`
 - `import_rules`: contains the domain rules for TAP families, 3 columns: TAP family, domain, rule (should or should not)
 - `import_species`: tabular file listing all species including full taxonomy and NCBI TaxID
 - `import_tap`: outputs of TAPscan analysis tool containing the TAP family classifications
 - `import_tapinfo`: a file containing description and citations for each TAP family
 - `trees`: this folder contains all trees included in the website
 - `fasta`: this folder contains all sequences, organized by species


## Installation

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
   - `docker-compose up -d` (or `make run`)

5. View  TAPscan application
   - By default the application will run at `http://0.0.0.0:8000`
   - no data is loaded yet, please see  [Preparing data for upload](#preparing-data-for-upload)

6. To stop the application
   - `docker-compose down` (or `make stop`)


**Troubleshooting**

If you encounter permission errors when viewing the website, please set the following permissions on the `public` and `storage` folders:

```
sudo chmod -R a+rwx public storage
```

### Configure Web Server

To serve the TAPscan website you need a bit of configuration of a webserver such as Apache or NGINX.

Below is an example nginx configuration:

```
server {
  listen 80 default_server;
  listen [::]:80 default_server;

  root /var/www/html/tapscan-v4/public;

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

If you load a large amount of data into your database, and the homepage becomes slow to load, you can utilize the page caching functionality of TAPscan. Below is the sample nginx configuration which will try serving the cached html page first:

```
server {
  listen 80 default_server;
  listen [::]:80 default_server;

  root /var/www/html/tapscan-v4/public;

  server_name tapscan.plantcode.cup.uni-freiburg.de;

  location = / {
    try_files /page-cache/families.html @tapscan;
  }

  location / {
    try_files /page-cache/$uri.html /page-cache/$uri.json /page-cache/$uri.xml /index.php?$query_string @tapscan;
  }

  location @tapscan {
    proxy_pass http://0.0.0.0:8000;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection 'upgrade';
    proxy_set_header Host $host;
    proxy_cache_bypass $http_upgrade;


  }
}
```

Note that in this case, the page cache must be cleared whenever new data is loaded or changes to the pages are made. This can be done by running

```
make clean
```


### Populating the database

The `_data` folder contains all the data we used to populate the main [TAPscan website](http://tapscan.plantcode.cup.uni-freiburg.de/).

Data can be uploaded via the admin panel in the TAPscan web interface, or via the commandline. For the initial data upload, we recommend using the commandline, because this step can take quite some time.

To load the TAPscan v4 data from the `_data` folder into the TAPscan database, follow the instructions below. To prepare your own data for upload, see the *"Preparing data for upload"* section.

1. Run the importers
   - `make import-data`
   - When it is done, the containers will shut down
   - The data that is uploaded to the database with this command is:
     ```
     _data/import-species/species_v4.csv
     _data/import-rules/rules_v82.txt
     _data/import-taps/taps_v4.csv
     _data/import-tapinfo/tapinfo_v4.csv
     _data/import-domains/domains_v4.csv
     ```
   - To run this importer with different data, simply replace the files mentioned above with your own.

3. To upload more data later, first create an admin user
   - navigate to `http://0.0.0.0:8000/register`
   - create an admin account
   - **Note:** only one account can be made, so make sure to remember your credentials!

4. Now there is an "Admin" section on the Data page (`http://0.0.0.0:8000/data`)
   - Here you can view (and edit) existing data
   - Or upload additional data files under *Data Upload*
   - We highly recommend updating the source files in the `_data` folder, and running `make recreate` or `make rebuild`
     instead of uploading new data via the Admin Upload panel only.

5. Put the per-species fasta files in `_data/fasta/`. These should be named like `LETTERCODE.fa`.
   The fasta files used in the TAPscan v4 website can be found in our [Rensing-Lab/Genome-Zoo GitHub repo](https://github.com/Rensing-Lab/Genome-Zoo).

**TIP:** The data upload step can be combined with the first configuration step by using the command `make configure-and-import`


### Deleting TAPscan

To throw away your TAPscan images, containers, volumes, you run `make delete`.
This will delete any data in the TAPscan database as well, so use with care!

To delete and rebuild TAPscan from the data in the `_data` folder, you can use `make rebuild`

## Preparing data for upload

Steps to follow to make data ready for inclusion in TAPscan:

### Species Lettercode

Make sure that each of your species has a unique (uppercase) lettercode. This lettercode must be consistent in the species information file, and the FASTA files.

### Sequence Files
Create a fasta file per species, place it in the `_data/fasta` folder, named by their lettercode, e.g. `ACTCH.fa, ZYGCI.fa` etc. Every header inside the fasta file must also begin with the lettercode followed by an underscore, e.g. `>ACTCH_AA512007.0`. Everything after the underscore is assumed to be protein identifier, and will be used to search on PLAZA.

In order to retain information about the organel/source of origin, a suffix (e.g. `_mt` for mitochondria) may be added to the FASTA headers, for example `>ACTCH_mt_AA512007.0`

Valid suffixes are:

```
_mt : mitochondria
_pl : plasmids
_pt : plastids
_hc : high conﬁdence proteins
_chl : chloroplast
_tr : transcriptome
_lc : low conﬁdence proteins
_org : organelle proteins (if the origin of the organelle proteins is not clear)
```

These are the fasta files you will run the TAPscan classify script on. The lettercode must match the species information file of the next step.

### Species information
- Format:
	- Semicolon (`;`) separated file
    - 8 columns: `lettercode;Kingiom/supergroup;phylum/clade; supergroup2;order;family;scientific name;NCBI TaxID`
    - First line assumed to be header line
    - The lettercode should be a unique ID for your species, it must match the names of the fasta files.
- Example: [TAPscanv4 Species file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-species/species_v4.csv)

### Rules
- Format:
	- Semicolon (`;`) separated file
    - 3 columns: `TAP family;Domain;Rule (should | should not)`
    - No header line
- Example: [TAPscanv4 Rules file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-rules/rules_v82.txt)

### TAPs
- Run the [TAPscan-classify](https://github.com/Rensing-Lab/TAPscan-classify) tool on your sequence files,
- The subfamily classification outputs (`*.output.3`) can be uploaded directly into the TAPscan website
- Format:
  - Semicolon (';') separate file
  - columns `GENE_ID;TAP_FAMILY;SUBFAMILY;NUMBER_OF_FAMILIES_FOUND;DOMAINS;`
  - First line assumed to be a header line

- Example: [TAPscanv4 Tap file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tap/taps_v4.csv)

### TAP information
- Format:
  - TAB-separated file
  - No header line
  - With 4 columns: `TAP name [TAB] Description [TAB] "reference1","reference2",.. [TAB] Type (TR|TF|PT)`
  - References can be free-text citations. Preferably with a DOI link.
- Example: [TAPscanv4 TapInfo file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tapinfo/tapinfo_v4.csv)

### Domains file
- Format:
  - Semicolon (`;`) separated file
  - With 2 columns: `Domain;PFAM ID`
  - No header line
  - PFAM IDs start with `PF`, e.g. `PF00249`
- Example: [TAPscanv4 TapInfo file](https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-domain/domains_v4.csv)

### Trees

- TODO: get script to generate trees from Romy and add here
- Newick trees (NJ and MJ) may be added for each TAP
- These are placed in the folder `_data/trees` and currently found if named like on of the following:
  - `MAFFT_aligntment_trim.fasta_LETTERCODE.treefile`
  - `MAFFT_reducedAligntment_trim.fasta_LETTERCODE.treefile`
  - `quicktree_alignment_LETTERCODE.tre`
  - `quicktree_reducedAlignment_LETTERCODE.tre`
- Tree Images:
  - Run the script in `_data/trees/svgs/generate_svgs.sh`
  - This will automatically create images for all the Newick trees in your folde
  - Note that your trees must used NCBI TaxIds in order to include the taxonomy in the image.







