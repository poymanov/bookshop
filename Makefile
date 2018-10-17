.PHONY : start build-start stop flush copy_env remove_dependencies \
				 install-vendor install-node-modules create-key create_assets \
				 migrate seed test app init init-demo

.DEFAULT_GOAL := start

start:
	docker-compose up -d

build-start:
	docker-compose up -d --build

stop:
	docker-compose down

flush:
	docker-compose down -v

copy_env:
	cp .docker.env.example .docker.env
	cp .env.example .env

remove_dependencies:
	docker-compose exec php rm -rf vendor
	docker-compose exec php rm -rf node_modules

install-vendor:
	docker-compose exec php composer install

install-node-modules:
	docker-compose exec php npm install

create-key:
	docker-compose exec php php artisan key:generate

create_assets:
	docker-compose exec php npm run dev

migrate:
	docker-compose exec php php artisan migrate

seed:
	docker-compose exec php php artisan db:seed

test:
	docker-compose exec php vendor/bin/phpunit

app:
	docker-compose exec php bash

init: flush copy_env build-start remove_dependencies install-vendor install-node-modules create-key create_assets migrate

init-demo: init seed
