FROM php:8-fpm-alpine

# Install dev dependencies
RUN apk add --update --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    coreutils \
    freetype-dev \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    linux-headers \
    oniguruma-dev

# Install production dependencies
RUN apk add --no-cache \
    bash \
    curl \
    freetype \
    git \
    icu \
    libjpeg-turbo \
    libpng \
    libwebp \
    libzip \
    mysql-client

## Install PECL and PEAR extensions
RUN pecl install xdebug

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

# Install and enable php extensions
RUN docker-php-ext-enable xdebug gd

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
