start: 
	php -S localhost:8000

install:
	composer install && composer run test

test:
	composer run test