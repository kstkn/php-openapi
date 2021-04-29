FROM php:5.5-cli
RUN apt-get update && apt-get install -y git libzip-dev zip wget libicu-dev
RUN docker-php-ext-configure zip --with-libzip && docker-php-ext-install zip
RUN pecl install xdebug-2.5.5
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-install intl
RUN wget -O "$PHP_INI_DIR/php.ini" https://raw.githubusercontent.com/php/php-src/PHP-5.5.38/php.ini-development
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
