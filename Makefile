.PHONY: help

env ?= dev

BRANCH_NAME ?= $(branch_name)

## Colors
COLOR_RESET			= \033[0m
COLOR_ERROR			= \033[31m
COLOR_INFO			= \033[32m
COLOR_COMMENT		= \033[33m
COLOR_TITLE_BLOCK	= \033[0;44m\033[37m

#---SYMFONY--#
SYMFONY_CONSOLE = symfony console
#------------#

#---SYMFONY--#
DOCKER_PHP = docker exec -it sf5-php
#------------#



#---PHP CLI--#
PHP_CLI = php -d memory_limit=4G
#------------#


#---PHPUNIT-#
PHPUNIT = APP_ENV=test php bin/phpunit
#------------#


# ---- DB - #
DB = docker exec -it sf5-mysql
#------------#

## === 🆘 HELP ==================================================
help: ## Show this help.
	@echo "Symfony-Makefile"
	@echo "---------------------------"
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
#---------------------------------------------#


sf-clear: ## Clear symfony cache.
	$(SYMFONY_CONSOLE) cache:clear
.PHONY: sf-clear

sf-dc: ## Create symfony database.
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists --env=$(env) 

sf-dd: ## Drop symfony database.
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force --env=$(env) 

sf-su: ## Update symfony schema database.
	$(SYMFONY_CONSOLE) doctrine:schema:update --force --env=$(env) 

sf-fixtures: ## Load fixtures
	#$(MAKE) alice-fixtures env=$(env)
	$(SYMFONY_CONSOLE) doctrine:fixtures:load -n

sf-cc: ## Load fixtures
	$(SYMFONY_CONSOLE) cache:clear --env=$(env)

do-mimi: ## migrate database
	$(SYMFONY_CONSOLE)  do:mi:mi

reset-db: ## Reset database.
	$(eval CONFIRM := $(shell read -p "Are you sure you want to reset the database? [y/N] " CONFIRM && echo $${CONFIRM:-N}))
	@if [ "$(CONFIRM)" = "y" ]; then \
		$(MAKE) sf-dd; \
		$(MAKE) sf-dc; \
		$(MAKE) sf-su; \
		$(MAKE) sf-fixtures; \
		$(MAKE) sf-cc; \
	fi
.PHONY: reset-db

## Activate group_by outside docker
docker-enable-group-by: ## Activate group_by outside docker
	$(DB) mysql -uroot -proot api_ter_test -e "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"

## === 🆘 TESTS ==================================================
database: ## Create database
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force --env=$(env)
	$(SYMFONY_CONSOLE) doctrine:database:create --env=$(env)
	$(SYMFONY_CONSOLE) doctrine:schema:update --force --env=$(env)



update-db: ## Update database
	$(SYMFONY_CONSOLE) doctrine:schema:update --force --dump-sql --env=$(env)

prepare: ## Prepare database
		$(MAKE) sf-dc; \
		$(MAKE) sf-su; \
		$(MAKE) sf-fixtures; \

simple-tests: ## Run simple tests
	php -d memory_limit=1G bin/phpunit --testdox
.PHONY: simple-tests

tests-filter: ## Run tests in container with filter (make tests-filter filter=Kpitest)
	php bin/phpunit --testdox --filter=$(filter)

docker-tests-filter: ## Run tests outcontainer with filter (make docker-tests-filter filter=Kpitest)
	docker exec -it sf5-php $(MAKE) tests-filter filter=$(filter)

allow-ci-prepush:
	bash contrib/setup.sh

docker-reset-db: ## Docker reset db test
	docker exec -it sf5-php make reset-db

docker-simple-tests: ## Run test
	docker exec -it sf5-php make simple-tests

docker-all: ## Prepare database 
		docker exec -it sf5-php make reset-db-alice
		$(MAKE) docker-simple-tests; \

all: ## Test database test from zero
		$(MAKE) reset-db-alice; \
		$(MAKE) simple-tests; \

tests-ci: ## Test database test from zero
		$(MAKE) phpstan; \
		$(MAKE) sf-dd; \
		$(MAKE) sf-dc; \
		$(MAKE) sf-su; \
		$(MAKE) sf-fixtures; \
		$(MAKE) simple-tests; \

## === 🆘 GIT ==================================================
git-prepare: ## Prepare GIT requirements : [make git-prepare]
	git config --global user.email "${GIT_USER_EMAIL}"
	git config --global user.name "${GIT_USER_NAME}"
#	bash /usr/sbin/update-ca-certificates
#	composer config -g secure-http false
	#git config --global http.sslVerify false
	git config --global --add safe.directory /home/wwwroot/sf5-p2

git-pull-dev: ## Retrieve GIT last version of origin/evol_lot1/ter_lo1_dev : [make git-pull-dev]
	$(MAKE) git-prepare user_email="${GIT_USER_EMAIL}" user_name="${GIT_USER_NAME}"; \
	git fetch origin
	git stash
	git checkout develop
	git reset --hard origin/develop
	git pull
	chmod -R 777 /home/wwwroot/sf5-p2


git-branch-switch: ## Retrieve GIT last version of a given branch : [make git-branch-switch branch_name=SSG]
	$(MAKE) git-prepare user_email="${GIT_USER_EMAIL}" user_name="${GIT_USER_NAME}"; \
	git fetch origin
	git stash
	git checkout $(BRANCH_NAME)
	git reset --hard origin/$(BRANCH_NAME)
	git pull
	chmod -R 777 /home/wwwroot/sf5-p2

jwt: ## Renew jwt inside container
	$(SYMFONY_CONSOLE) lexik:jwt:generate-keypair --overwrite -n

docker-jwt: ## Renew jwt outside container
	docker exec -it sf5-php $(MAKE) jwt

composer-install: ## composer install 
	docker exec -it sf5-php composer install

composer-update-ter-common: ## update ter common
	docker exec -it sf5-php composer update ter/common

## Install all 
install-all: 
	sed -i 's/APP_ENV=prod/APP_ENV=dev/g' .env.local
	$(MAKE) composer-install

## === 🆘 CODE QUALITY ==========================================
psalm: ## RUN psalm stats and redirect it inside ./psalm_report.log : [make psalm]
	$(PHP_CLI) ./vendor/bin/psalm src tests

phpstan: ## RUN phpstan stats and redirect it inside ./phpstan_report.log : [make psalm]
	$(PHP_CLI) ./vendor/bin/phpstan analyse -c phpstan.neon src tests

phpinsights-clean: ## Run phpinsights (exple: make phpinsights-clean file=src/Controller/MailBoxController.php )
	$(PHP_CLI) ./vendor/bin/phpinsights analyse $(file) --no-interaction --fix

phpmd: ## RUN phpmd stats and redirect it inside ./phpmd_report.log : [make phpmd]
	$(PHP_CLI) ./vendor/bin/phpmd src,tests text /home/wwwroot/ter-api/phpmd.rulesets.xml

phpcs: ## RUN phpcs stats and redirect it inside ./phpcs_report.log : [make phpcs]
	$(PHP_CLI) ./vendor/bin/phpcs src tests --report=summary > /home/wwwroot/ter-api/phpcs_report.log

php-stats-code: ## RUN all PHP code analysers tools : [make php-stats-code]
	$(MAKE) psalm; \
	$(MAKE) phpstan; \
	$(MAKE) phpmd; \
	$(MAKE) phpcs

alice-fixtures: ## Run Alice fixture inside container (in test env ==>make alice, in dev env make alice env=dev)
	$(SYMFONY_CONSOLE) hautelook:fixtures:load --no-interaction --purge-with-truncate --env=$(env)

docker-alice-fixtures: ## Run Alice fixture out of container (in test env ==>make docker-alice, in dev env make docker-alice env=dev)
	$(DOCKER_PHP) $(MAKE) alice-fixtures env=$(env)


reset-db-alice: ## Reset database.
	$(eval CONFIRM := $(shell read -p "Are you sure you want to reset the database? [y/N] " CONFIRM && echo $${CONFIRM:-N}))
	@if [ "$(CONFIRM)" = "y" ]; then \
		$(MAKE) sf-dd; \
		$(MAKE) sf-dc; \
		$(MAKE) sf-su; \
		$(MAKE) alice-fixtures; \
		$(MAKE) sf-cc; \
	fi

docker-all-alice: ## Prepare database 
		docker exec -it sf5-php make reset-db-alice
		$(MAKE) docker-simple-tests; \

all-alice: ## Test database test from zero
		$(MAKE) reset-db-alice; \
		$(MAKE) simple-tests; \


uss: ## update time slots status inside container
	$(SYMFONY_CONSOLE) app:time-slot-status-update

duss: ## update time slots status from outside container
	docker exec -it sf5-php $(MAKE) uss

migrate-version: ## migrate version from
	php bin/console doctrine:migration:execute --up 'DoctrineMigrations\Version20230303103510' -n
muv: ## migrate up version number
	php bin/console doctrine:migration:execute --up 'DoctrineMigrations\$(version)' -n
mdv: ## migrate version from
	php bin/console doctrine:migration:execute --down 'DoctrineMigrations\'$(version) -n


## === 🆘 MESSENGER / SERVER DUMP ========================================
messenger-consume: ## Consume messages from the queue inside container
	$(SYMFONY_CONSOLE) messenger:consume async -vv

docker-messenger-consume: ## Consume messages from the queue outside container
	docker exec -it sf5-php $(MAKE) messenger:consume async -vv

dump: ## dump var inside container
	$(SYMFONY_CONSOLE) server:dump

docker-dump: ## dump var outside container
	docker exec -it sf5-php $(MAKE) dump


## === 🆘 MASS USER IMPORT ========================================
import-user: ## execute mass user import
	$(SYMFONY_CONSOLE) app:mass-user-import

send-mails: ## handle Messenger Mailer queue
	$(SYMFONY_CONSOLE) app:send-mail-queue

fake-import-user: ## execute mass user import
	$(SYMFONY_CONSOLE) app:user-import-csv-generator $(company) $(nb_lines) -i