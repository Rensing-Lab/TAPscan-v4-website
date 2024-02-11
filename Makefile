configure:
	./vendor/bin/sail up -d
	./check_container_status.sh tapscan_v4_mysql
	./vendor/bin/sail composer update
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan config:cache
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
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan config:cache
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate:install
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail artisan db:seed
	./vendor/bin/sail composer update
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev
	./vendor/bin/sail artisan import:tapscan_data
	./vendor/bin/sail down

run:
	docker-compose up
stop:
	docker-compose down
restart:
	docker-compose restart

delete: # use with care, will delete everything!
	./vendor/bin/sail down --rmi all -v

