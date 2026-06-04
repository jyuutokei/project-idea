FROM dunglas/frankenphp:php8.5-alpine AS build

RUN apk add --no-cache \
    git \
    unzip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN install-php-extensions \
    pdo_sqlite \
    sqlite3 \
    mbstring \
    opcache \
    pcntl \
    zip \
    bcmath \
    gd \
    intl \
    redis 

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-scripts \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize --no-dev


FROM dunglas/frankenphp:php8.5-alpine AS production

# copy system libraries needed by runtime extensions (e.g., gd, intl)
# mostly image formats that gd depends on, but also ICU for intl
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    icu-libs \
    libzip \
    libavif \
    lz4-libs \
    libwebp \
    libxpm \
    giflib

COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

COPY --from=build /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=build /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

RUN addgroup -g 1000 appgroup && adduser -u 1000 -D -G appgroup appuser

WORKDIR /app

COPY --from=build /app /app

RUN mkdir -p storage bootstrap/cache database \
    && chown -R appuser:appgroup storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

COPY ./docker/Caddyfile /etc/caddy/Caddyfile
COPY ./docker/php.ini /usr/local/etc/php/conf.d/99-custom.ini

EXPOSE 80 443

ENTRYPOINT [ "/usr/local/bin/entrypoint.sh" ]

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile" ]