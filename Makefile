SHELL := /bin/bash

start:
	@echo "make [option]"
	@echo "OPTIONS:"
	@echo '	migration       - create doctrine migration'
	@echo '	migrate         - migrate database'
	@echo '	serverStart     - migrate database'
	@echo '	serverStop      - migrate database'
	@echo '	entity          - create entity'
	@echo '	lint      		- phpcs'
	@echo '	lint-fix        - phpcbf'
migration:
	symfony console make:migration
migrate:
	symfony console doctrine:migrations:migrate
serverStart:
	symfony server:start -d
serverStop:
	symfony server:stop
entity:
	symfony console make:entity
lint:
	./vendor/bin/phpcs --standard=ruleset.xml ./src
lint-fix:
	./vendor/bin/phpcbf --standard=ruleset.xml ./src