ROOT_DIR = $(shell pwd)

USE_DOCKER = NO

DATABASE_NAME = y2aa
DATABASE_NAME_TEST = y2aa-test

WWW_FOLDER = y2aa

DEV_DOCKER_CONTAINER_PHP_FPM ?= y2aa_php_fpm
DEV_DOCKER_CONTAINER_NGINX ?= y2aa_nginx
DEV_DOCKER_CONTAINER_MYSQL ?= y2aa_mysql

PROD_DOCKER_CONTAINER_PHP_FPM ?= y2aa_php_fpm
PROD_DOCKER_CONTAINER_NGINX ?= y2aa_nginx
PROD_DOCKER_CONTAINER_MYSQL ?= y2aa_mysql

PHP_CMD_PREFIX = 
NGINX_CMD_PREFIX = 
MYSQL_CMD_PREFIX =

PREFIX_DOCKER_PHP_FPM = docker exec $(DEV_DOCKER_CONTAINER_PHP_FPM)
PREFIX_DOCKER_NGINX = docker exec $(DEV_DOCKER_CONTAINER_NGINX)
PREFIX_DOCKER_MYSQL = docker exec $(DEV_DOCKER_CONTAINER_MYSQL)

PREFIX_DOCKER_PROD_PHP_FPM = docker exec -w /usr/share/nginx/html/$(WWW_FOLDER) $(PROD_DOCKER_CONTAINER_PHP_FPM)
PREFIX_DOCKER_PROD_NGINX = docker exec -w /usr/share/nginx/html/$(WWW_FOLDER) $(PROD_DOCKER_CONTAINER_NGINX)
PREFIX_DOCKER_PROD_MYSQL = docker exec $(PROD_DOCKER_CONTAINER_MYSQL)

ENVIRONMENT_TYPE = P
ENVIRONMENT_NAME = PROD

ifdef Y2AA_ENVIRONMENT_DEV
	ENVIRONMENT_TYPE = D
	ENVIRONMENT_NAME = DEV
endif

ifeq ($(docker), 1)
	USE_DOCKER = YES

	ifeq ($(ENVIRONMENT_TYPE), D)
		PHP_CMD_PREFIX = $(PREFIX_DOCKER_PHP_FPM)
		NGINX_CMD_PREFIX = $(PREFIX_DOCKER_NGINX)
		MYSQL_CMD_PREFIX = $(PREFIX_DOCKER_MYSQL)
	else
		PHP_CMD_PREFIX = $(PREFIX_DOCKER_PROD_PHP_FPM)
		NGINX_CMD_PREFIX = $(PREFIX_DOCKER_PROD_NGINX)
		MYSQL_CMD_PREFIX = $(PREFIX_DOCKER_PROD_MYSQL)
	endif
endif

.DEFAULT_GOAL := help

# general
help:
	@echo "Type: make [rule]."
	@echo "Hint: Add parameter 'docker=1' at last to execute on Docker."
	@echo ""
	@echo "Environment: $(ENVIRONMENT_NAME)"
	@echo "Use docker:  $(USE_DOCKER)"
	@echo ""
	@echo "Available options are:"
	@echo ""
	@echo "- help"
	@echo "- clear"
	@echo "- nginx-reload"
	@echo "- requirements"
	@echo ""
	@echo "- docker-compose-start"
	@echo "- docker-compose-stop"
	@echo "- docker-compose-start-console"
	@echo "- docker-compose-rebuild"
	@echo ""
	@echo "- config-env-development"
	@echo "- config-env-production"
	@echo ""
	@echo "- create-db"
	@echo "- create-db-test"
	@echo ""
	@echo "- php-composer-install"
	@echo "- php-composer-update"
	@echo "- php-composer-outdated"
	@echo "- php-composer-show"
	@echo "- php-composer-clear-cache"
	@echo "- php-composer-remove"
	@echo ""
	@echo "- migrate-db"
	@echo "- migrate-db-test"
	@echo ""
	@echo "- php-gd"
	@echo ""
	@echo "- test"
	@echo ""
	@echo "- prod-update"
	@echo "- cloudflare-clear-cache"
	@echo "- cache-invalidate"
	@echo ""
	@echo "- console-test"
	@echo "- console-permissions-generate"
	@echo "- console-data-all"
	@echo ""
	@echo "- console-create-cache-table"
	@echo "- console-create-cache-table-test"
	@echo ""

clear:
	rm -rf backend/runtime/*
	rm -rf frontend/runtime/*
	rm -rf common/runtime/*
	rm -rf ws/runtime/*
	rm -rf console/runtime/*

	rm -rf backend/web/assets/*
	rm -rf frontend/web/assets/*
	rm -rf common/web/assets/*

docker-compose-start:
	cd extras/docker && \
	    WWW_DIR=$(ROOT_DIR) docker-compose up -d

docker-compose-start-console:
	cd extras/docker && \
	    WWW_DIR=$(ROOT_DIR) docker-compose up

docker-compose-stop:
	cd extras/docker && \
	    WWW_DIR=$(ROOT_DIR) docker-compose down

docker-compose-rebuild:
	cd extras/docker && \
	    WWW_DIR=$(ROOT_DIR) docker-compose build --force-rm

config-env-development:
	$(PHP_CMD_PREFIX) make clear
	$(PHP_CMD_PREFIX) php init --env=Development --overwrite=All
	$(PHP_CMD_PREFIX) mkdir -p uploads/general

config-env-production:
	$(PHP_CMD_PREFIX) make clear
	$(PHP_CMD_PREFIX) php init --env=Production --overwrite=All
	$(PHP_CMD_PREFIX) mkdir -p uploads/general

migrate-db:
	$(PHP_CMD_PREFIX) php yii migrate --migrationPath=@common/migrations --interactive=0
	$(PHP_CMD_PREFIX) php yii migrate --migrationPath=@backend/migrations --interactive=0
	$(PHP_CMD_PREFIX) php yii migrate --migrationPath=@frontend/migrations --interactive=0
	$(PHP_CMD_PREFIX) php yii migrate --migrationPath=@ws/migrations --interactive=0

migrate-db-test:
	$(PHP_CMD_PREFIX) php yii_test migrate --migrationPath=@common/migrations --interactive=0
	$(PHP_CMD_PREFIX) php yii_test migrate --migrationPath=@backend/migrations --interactive=0
	$(PHP_CMD_PREFIX) php yii_test migrate --migrationPath=@frontend/migrations --interactive=0
	$(PHP_CMD_PREFIX) php yii_test migrate --migrationPath=@ws/migrations --interactive=0

create-db:
	$(MYSQL_CMD_PREFIX) mysql -u root -proot -e 'CREATE DATABASE IF NOT EXISTS `$(DATABASE_NAME)` DEFAULT CHARACTER SET = `utf8`;'

create-db-test:
	$(MYSQL_CMD_PREFIX) mysql -u root -proot -e 'CREATE DATABASE IF NOT EXISTS `$(DATABASE_NAME_TEST)` DEFAULT CHARACTER SET = `utf8`;'

nginx-reload:
	$(NGINX_CMD_PREFIX) service nginx reload

php-composer-install:
	$(PHP_CMD_PREFIX) php composer.phar install

php-composer-update:
	$(PHP_CMD_PREFIX) php composer.phar update

php-composer-outdated:
	$(PHP_CMD_PREFIX) php composer.phar outdated

php-composer-show:
	$(PHP_CMD_PREFIX) php composer.phar show -l

php-composer-clear-cache:
	$(PHP_CMD_PREFIX) php composer.phar clear-cache

php-composer-remove:
	$(PHP_CMD_PREFIX) rm -rf vendor
	$(PHP_CMD_PREFIX) rm -rf composer.lock

php-gd:
	$(PHP_CMD_PREFIX) php -r 'print_r(gd_info());'

test:
	$(PHP_CMD_PREFIX) php composer.phar validate
	$(PHP_CMD_PREFIX) vendor/bin/codecept run

requirements:
	$(PHP_CMD_PREFIX) php requirements.php

cloudflare-clear-cache:
	curl -X DELETE \
      https://api.cloudflare.com/client/v4/zones/[DOMAIN-ZONE-ID]/purge_cache \
      -H 'Authorization: Bearer [MY-TOKEN]' \
      -H 'Content-Type: application/json' \
      -d '{ "purge_everything": true }'

cloudflare-list-zones:
	curl -X GET "https://api.cloudflare.com/client/v4/zones?name=[MY-DOMAIN]&status=active&match=all" \
     -H 'Authorization: Bearer [MY-TOKEN]' \
     -H "Content-Type: application/json"

prod-update:
	git pull origin master
	make php-composer-update docker=1
	make config-env-production docker=1
	make migrate-db docker=1
	make clear
	make cache-invalidate docker=1
	make cloudflare-clear-cache
	make console-permissions-generate docker=1

cache-invalidate:
	$(PHP_CMD_PREFIX) php yii cache/flush-all

console-test:
	$(PHP_CMD_PREFIX) php yii test/test

console-permissions-generate:
	$(PHP_CMD_PREFIX) php yii permissions/generate

console-data-all:
	$(PHP_CMD_PREFIX) php yii data/languages
	$(PHP_CMD_PREFIX) php yii data/groups
	$(PHP_CMD_PREFIX) php yii data/users
	$(PHP_CMD_PREFIX) php yii data/customers
	$(PHP_CMD_PREFIX) php yii data/contents

console-create-cache-table:
	$(PHP_CMD_PREFIX) php yii data/cache-table

console-create-cache-table-test:
	$(PHP_CMD_PREFIX) php yii_test data/cache-table
