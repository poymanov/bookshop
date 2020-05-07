init: docker-down-clear \
		docker-pull docker-build docker-up \
		php-cli-init node-cli-init

php-cli-init: copy-env php-cli-permissions \
		composer-install php-cli-wait-db migrate \
		seed create-key install-passport \
		php-cli-clear php-cli-create-storage-link

node-cli-init: npm-install npm-build-dev

test: php-cli-test

up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm php-cli composer install

migrate:
	docker-compose run --rm php-cli php artisan migrate

seed:
	docker-compose run --rm php-cli php artisan db:seed

create-key:
	docker-compose run --rm php-cli php artisan key:generate

install-passport:
	docker-compose run --rm php-cli php artisan passport:install --force

copy-env:
	cp .env.example .env

php-cli-wait-db:
	docker-compose run --rm php-cli wait-for-it db:3306 -t 30

php-cli-permissions:
	docker run --rm -v ${PWD}:/var/www -w /var/www alpine chmod 777 -R storage

php-cli-clear:
	docker run --rm -v ${PWD}:/var/www -w /var/www alpine rm -rf public/storage

php-cli-create-storage-link:
	docker-compose run --rm php-cli php artisan storage:link

npm-install:
	docker-compose run --rm node-cli npm install

npm-build-dev:
	docker-compose run --rm node-cli npm run dev

php-cli-test:
	docker-compose run --rm php-cli php vendor/bin/phpunit

php-cli-import-search-index:
	docker-compose run --rm php-cli php artisan scout:import-all
