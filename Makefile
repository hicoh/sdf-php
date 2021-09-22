# Note. If you change this, you also need to update docker-compose.yml.
# only useful in a setting with multiple services/ makefiles.
SERVICE_TARGET := app

PHPEXEC=docker-compose exec app

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
	@docker-compose exec --env XDEBUG_MODE=off app ./vendor/bin/parallel-lint --no-progress --exclude bin --exclude var --exclude vendor --blame .

phpstan:
	# Perform a static codebase analysis.
	@docker-compose exec --env XDEBUG_MODE=off app ./vendor/bin/phpstan analyze -c phpstan.neon --no-progress --level=7 src --memory-limit=-1

phpcs:
	# Check the coding style.
	@docker-compose exec --env XDEBUG_MODE=off app ./vendor/bin/php-cs-fixer fix -v --dry-run --stop-on-violation

csfix:
	# Fix coding style.
	@docker-compose exec --env XDEBUG_MODE=off app ./vendor/bin/php-cs-fixer fix

## Testing

.PHONY: test test-unit

test: phpunit ## Run the test suites.

PHPUNIT_FLAGS ?=

phpunit:
	# Running all of the tests
	@docker-compose exec --env XDEBUG_MODE=off app php bin/phpunit

unit-tests:
	# Running the unit tests
	@docker-compose exec --env XDEBUG_MODE=off app php bin/phpunit tests/Unit/

integration-tests:
	# Running the integration tests
	@docker-compose exec --env XDEBUG_MODE=off app php bin/phpunit tests/Integration

code-coverage:
	# Generating code coverage
	@docker-compose exec --env XDEBUG_MODE=coverage app php bin/phpunit --coverage-text=code-coverage.txt

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
