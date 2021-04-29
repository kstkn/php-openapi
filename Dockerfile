FROM php:5.5-cli
RUN apt-get update && apt-get install -y git libzip-dev zip
RUN docker-php-ext-configure zip --with-libzip && docker-php-ext-install zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
