FROM php:7.4-apache
LABEL maintainer="titangene.tw@gmail.com"

# Install the PHP extensions we need
RUN set -ex; \
	apt-get update; \
        apt-get install libpq-dev -y; \
        docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_pgsql; \
	rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
