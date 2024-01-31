first-run:
	./vendor/bin/sail up

configure:
	./vendor/bin/sail artisan config:cache
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate:install
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail composer update
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev
	./vendor/bin/sail down

run:
	docker-compose up
stop:
	docker-compose down
restart:
	docker-compose restart
cleanup:
	./vendor/bin/sail down --rmi all -v
