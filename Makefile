current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
SHELL = /bin/sh
docker-container = webserver-witrac

#
# ❓ Help output
#
help: ## Show make targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\/]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-24s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

#
# 🐘 Build and run
#
start: ## Start and run project
	docker-compose up -d

stop: ## Stop project
	docker-compose down

install: ## Install dependencies
	docker exec $(docker-container) composer install

bash: ## Start bash console inside the container
	docker exec --user www-data -it $(docker-container) /bin/bash

migrate/dev: ## Migrate database for development
	docker exec $(docker-container) php bin/console doctrine:migrations:migrate --env=dev

migrate/test: ## Migrate database for testing
	docker exec $(docker-container) php bin/console doctrine:migrations:migrate --env=test

test/unit: ## Execute unit tests
	docker exec $(docker-container) ./vendor/bin/phpunit --testsuite Unit

test/functional: ## Execute functional tests
	docker exec $(docker-container) ./vendor/bin/behat
