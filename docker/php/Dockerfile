FROM php:7.2-fpm

RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) bcmath
RUN apt-get update
RUN apt-get install libsodium-dev
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    screen
RUN docker-php-ext-install zip
RUN docker-php-ext-install -j$(nproc) sodium
RUN docker-php-ext-install -j$(nproc) sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app