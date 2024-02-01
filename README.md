# TAPscan v4

This repository contains the source code for the TAPscan v4 website: [tapscan.plantcode.cup.uni-freiburg.de](http://tapscan.plantcode.cup.uni-freiburg.de)


## First time setup

If you would like to run your own copy of TAPscan with your own data, you can follow the following procedure.

### Install dependencies

1. Install Docker on your system according to the [official instructions](https://docs.docker.com/engine/install/)

2. Install the following packages on your system, this example is for Ubuntu (TODO Deepti: what dependencies were missing on fresh system?)

```
sudo apt-get install
```

### Install TAPscan

0. Clone this GitHub repo

1. Configure settings:

```
cp env.example .env  #create a copy of the example env file
# edit .env file as needed
```

2. Start the application for the first time
   -  `make first-run`

This will run the application in docker. Once it has started successfully, open a new terminal and run the configuration step:

2. Apply configuration:
   - `make configure`

This may take a few minutes, when everything is ready, the containers will be stopped. From now on, we can control TAPscan directly using the docker compose file.

3. Start TAPscan application
   - `docker-compose up` (or `make run`)

4. View  TAPscan application
   - By default the application will run at `http://0.0.0.0:8000`

5. To stop the application
   - `docker-compose down` (or `make stop`)

**Troubleshooting**

If you encounter permission errors, please set the following permissions on the public and storage folders:

```
chmod -R a+rwx public storage
```



### Adding Data: Populating the database

The `_data` folder contains all the data used to populate the TAPscan website.

To load this or other data into TAPscan:

1. Create an admin user
   - navigate to `http://0.0.0.0/register`
   - create an admin account

2. Upload data via the Admin panel.


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




