# TAPscan v4

This repository contains the source code for the TAPscan v4 website: [tapscan.plantcode.cup.uni-freiburg.de](http://tapscan.plantcode.cup.uni-freiburg.de)


## First time setup

0. Clone this GitHub repo

1. Configure settings:

```
cp env.example .env  #create a copy of the example env file
# edit .env file as needed
```

2. Apply configuration:

```
make configure
```

This will take a few minutes, when everything is ready, there


3. Start TAPscan application
   - `docker-compose up` (or `make run`)

4. View  TAPscan application
   - By default the application will run at `http://0.0.0.0:8000`


### Troubleshooting

You may need to update the permissions of the storage folder

```
chmod -R a+rwx public storage
```



## Adding Data: Populating the database

The `_data` folder contains all the data used to populate the TAPscan website.

To load this or other data into TAPscan:

1. Create an admin user
   - navigate to `http://0.0.0.0/register`
   - create an admin account

2. Upload data


## Configure Web server

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

Steps to follow to



## Debug/dev notes

```
# remove all docker images, containers and volumes if setup goes wrong
./vendor/bin/sail down --rmi all -v
```




