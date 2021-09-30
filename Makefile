SERVICE_TARGET := app

PHPEXEC=docker-compose exec --env XDEBUG_MODE=off app

.DEFAULT_GOAL=help

.PHONY: deps

.PHONY: build rebuild start stop

build:	## Build the app docker container.
	@docker-compose build $(SERVICE_TARGET)
	make deps

deps:
	make start
	$(PHPEXEC) composer install
	make stop

rebuild:	## Force a rebuild of the app docker image.
	@docker-compose build --pull --no-cache --force-rm $(SERVICE_TARGET)
	make deps

start: ## Run as a background service.
	@docker-compose -f docker-compose.yml up -d

stop: ## Stop services.
	@docker-compose -f docker-compose.yml stop

cc: ## clear Symfony cache
	@docker-compose exec --env XDEBUG_MODE=off app php bin/console cache:clear

ssh: ## ssh access
	@docker-compose exec --env XDEBUG_MODE=off app bash

## Linting

.PHONY: lint phplint phpstan phpcs

lint: phplint phpstan phpcs ## Perform a codebase analysis.

phplint:
	# Syntax checking
	$(PHPEXEC) ./vendor/bin/parallel-lint --no-progress --exclude bin --exclude var --exclude vendor --blame .

phpstan:
	# Perform a static codebase analysis.
	$(PHPEXEC) ./vendor/bin/phpstan analyze -c phpstan.neon --no-progress --level=7 src --memory-limit=-1

phpcs:
	# Check the coding style.
	$(PHPEXEC) ./vendor/bin/php-cs-fixer fix -v --dry-run --stop-on-violation

csfix:
	# Fix coding style.
	$(PHPEXEC) ./vendor/bin/php-cs-fixer fix

## Testing
.PHONY: test test-unit

test: phpunit ## Run the test suites.

## Dependencies
composer-install:
	$(PHPEXEC) composer install
composer-dumpautoload:
	$(PHPEXEC) composer dumpautoload

## Package Commands
create-function: ### Create a function
	$(PHPEXEC) php bin/console app:create-function
	make composer-install
	make composer-dumpautoload
delete-function: ### Delete a function
	$(PHPEXEC) php bin/console app:delete-function
	make composer-install
	make composer-dumpautoload


PHPUNIT_FLAGS ?=

phpunit:
	# Running all of the tests
	$(PHPEXEC) php bin/phpunit

unit-tests:
	# Running the unit tests
	$(PHPEXEC) php bin/phpunit tests/Unit/

integration-tests:
	# Running the integration tests
	$(PHPEXEC) php bin/phpunit tests/Integration

code-coverage:
	# Generating code coverage
	$(PHPEXEC) php bin/phpunit --coverage-text=code-coverage.txt

security-check: vendor ## Generate a security vulnerabilities report.
	vendor/bin/security-checker security:check -n

.PHONY: clean
clean: ## Remove created images, containers and dependencies.
	docker-compose down --rmi all --remove-orphans 2>/dev/null
	rm -rf vendor/

.PHONY: help
help: ## Show this help.
	@echo ""
	@echo "Usage:"
	@echo "  make [targets...]"
	@echo ""
	@echo "Targets:"
	@awk -F ':|##' '/^[^\t].+?:.*?##/ {\
		printf "  \033[36m%-20s\033[0m %s\n", $$1, $$NF \
	}' $(MAKEFILE_LIST)
	@echo "Package Commands:"
	@awk -F ':|###' '/^[^\t].+?:.*?###/ {\
		printf "  \033[36m%-20s\033[0m %s\n", $$1, $$NF \
	}' $(MAKEFILE_LIST)
