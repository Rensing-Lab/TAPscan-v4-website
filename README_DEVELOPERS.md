# Developer/admin guide

## Running TAPscan

- `install docker`
- `clone this repo`
- `make rebuild`
- `make permissions` (to set )

- cofigure web server (see README)


## troubleshooting

To get debug info, set the following in .env file

```
APP_ENV=local
DEBUG=true
```

For productions, set

```
APP_ENV=production
DEBUG=false
```

## adding data

While it is possible to update the data in TAPscan via the admin interface, it is better to configure the data in the repo, and just rebuild TAPscan from scratch. The setup with docker is designed to make this easy. And this makes it easy to move TAPscan to a different location.

- update one of the files in `_data` folder
- run `make recreate` to throw away the running TAPscan, and recreate it with the new data
- you will have to register the admin account again after redeploying

## adding news

Do this in `resources/views/news/index.blade.php`

## adding new database tables

- add a file in `/database/migrations` which creates (or updates) your table
- to load data from a csv file, add it to `_data/` folder
- load the data into database by
  - creating a model for the data in `app/Models`
  - creating an importer in `app/Imports/`
  - adding an import call to `app/Console/Commands/ImportTAPscanData.php:`

## updating pages

- Update the relevant Conroller to expose the data you want to display
  - `app/Http/Controllers
- Display data where you want
  - `resources/views`


