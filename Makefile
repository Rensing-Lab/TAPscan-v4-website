clean:
	./vendor/bin/sail artisan page-cache:clear
	./vendor/bin/sail artisan route:clear

configure:
	./vendor/bin/sail up -d
	./check_container_status.sh tapscan_v4_mysql
	./vendor/bin/sail composer update
	./vendor/bin/sail artisan page-cache:clear
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan route:clear
	./vendor/bin/sail artisan config:cache
	./vendor/bin/sail artisan route:cache
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate:install
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail artisan db:seed
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev
	./vendor/bin/sail down

import-data:
	./vendor/bin/sail up -d
	./check_container_status.sh tapscan_v4_mysql
	./vendor/bin/sail artisan import:tapscan_data
	./vendor/bin/sail down

configure-and-import:
	./vendor/bin/sail up -d
	./check_container_status.sh tapscan_v4_mysql
	./vendor/bin/sail composer update
	./vendor/bin/sail artisan page-cache:clear
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan route:clear
	./vendor/bin/sail artisan config:cache
	./vendor/bin/sail artisan route:cache
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate:install
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail artisan db:seed
	./vendor/bin/sail composer update
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev
	./vendor/bin/sail artisan import:tapscan_data
	./vendor/bin/sail down

permissions:
	sudo chmod -R 775 public storage

clear-cache:
	rm -rf bootstrap/cache/*.php

run:
	docker-compose up -d
stop:
	docker-compose down
restart:
	docker-compose restart

delete: # use with care, will delete everything, volumes (your database) and docker containers and images, everything!
	./vendor/bin/sail down --rmi all -v

wipe: # removes volumes (your database), keeps docker images
	./vendor/bin/sail down -v

rebuild: delete configure-and-import clear-cache run #use with care, will delete everything and rebuild from scratch

recreate: wipe configure-and-import clear-cache run #use with care, will delete your database and rebuild it
