FROM php:8.2-fpm

ENV TZ Asia/Tokyo

# Node.js 20.x LTSのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

RUN apt-get update && \
    apt-get install -y git unzip libzip-dev libicu-dev libonig-dev libxml2-dev libcurl4-openssl-dev && \
    docker-php-ext-install intl pdo_mysql zip bcmath xml dom curl

COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Laravel entrypoint script for automatic permissions setup
COPY ./docker/app/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /app

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
