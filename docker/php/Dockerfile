# base image build
FROM php:7.2-fpm-alpine3.12 as base

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
        tzdata \
        bash \
        autoconf \
        freetype-dev \
        libzip-dev \
        libpng-dev \
        jpeg-dev \
        openssl-dev \
        nodejs \
        npm 

RUN docker-php-ext-configure gd --with-freetype-dir --with-jpeg-dir \
    && docker-php-ext-install -j$(nproc) gd bcmath pdo_mysql zip 

# local development build here
FROM base as local

RUN set -eux; \
	apk add busybox-suid; \
    apk add git

# create dev user
RUN set -eux; \
    addgroup -g 1000 -S dev; \
    adduser -S dev -u 1000 -G dev -s /bin/sh; \
    addgroup dev www-data; \
    addgroup www-data dev;

