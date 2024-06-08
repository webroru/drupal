FROM php:8-fpm-alpine as base

# Install build dependencies
RUN apk add --update --no-cache --virtual .build-deps \
    coreutils \
    freetype-dev \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    oniguruma-dev

# Install permanent packages
RUN apk add --no-cache \
    freetype \
    icu \
    libjpeg-turbo \
    libpng \
    libwebp \
    libzip \
    mysql-client

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg=/usr/include \
    --with-webp

RUN docker-php-ext-install -j "$(nproc)" \
    bcmath \
    gd \
    intl \
    mbstring \
    opcache \
    pdo \
    pdo_mysql \
    zip

RUN docker-php-ext-enable gd

RUN apk del .build-deps && \
    rm -rf /var/cache/apk/*

RUN { \
      echo 'opcache.memory_consumption=128'; \
      echo 'opcache.interned_strings_buffer=8'; \
      echo 'opcache.max_accelerated_files=4000'; \
      echo 'opcache.revalidate_freq=60'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

ENV PATH=${PATH}:/var/www/html/vendor/bin

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

FROM base as dev

RUN apk add --no-cache \
    bash

RUN apk add --update --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    linux-headers

RUN pecl install xdebug

RUN docker-php-ext-enable xdebug

RUN apk del .build-deps \
    && rm -rf /var/cache/apk/*

CMD mkdir web/sites/default/files \
    && mkdir web/sites/default/files/translations \
    && chown -R www-data: web/sites/default/files
