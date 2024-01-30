# TAPscan v4

This repository contains the source code for the TAPscan v4 website: [tapscan.plantcode.cup.uni-freiburg.de](http://tapscan.plantcode.cup.uni-freiburg.de)


## First time setup

1. Configure settings:

```
cp env.example .env
# fill in the values for password
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
   -




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

```

## Preparing data for upload

Steps to follow to



## Debug/dev notes

```
# remove all docker images, containers and volumes if setup goes wrong
./vendor/bin/sail down --rmi all -v
```




