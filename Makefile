configure:
	./vendor/bin/sail up -d
	sleep 120
	./vendor/bin/sail artisan config:cache
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate:install
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail composer update
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev
	./vendor/bin/sail down
	chmod -R a+rwx storage/framework/views

run:
	docker-compose up
stop:
	docker-compose down
restart:
	docker-compose restart