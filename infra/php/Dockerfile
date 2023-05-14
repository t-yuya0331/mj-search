FROM php:8.0-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

COPY --from=composer:2.1.11 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get -y install git unzip libzip-dev libicu-dev libonig-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install intl pdo_mysql zip bcmath    
COPY ./php.ini /usr/local/etc/php/php.ini
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

# phpredis
RUN pecl install redis && \
    docker-php-ext-enable redis
    
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

WORKDIR /work