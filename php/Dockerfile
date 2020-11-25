FROM php:7.4-fpm-alpine3.12

#RUN echo "http://mirror.yandex.ru/mirrors/alpine/v3.12/main" > /etc/apk/repositories; \
#    echo "http://mirror.yandex.ru/mirrors/alpine/v3.12/community" >> /etc/apk/repositories

RUN apk update \
 && apk add --no-cache \
    bash \
    git \

    zip \
    unzip \
 && rm -rf /var/cache/apk/* \
 && rm -rf /tmp/*

RUN apk --update --no-cache add \
  php-bcmath \
  php-dom \
  php-ctype \
  php-curl \
  php-fileinfo \
  php-fpm \
  php-gd \
  php-iconv \
  php-intl \
  php-json \
  php-mbstring \
  php-opcache \
  php-openssl \
  php-pdo \
  php-pdo_pgsql \
  php-pdo_sqlite \
  php-pgsql \
  php-phar \
  php-posix \
  php-simplexml \
  php-session \
  php-soap \
  php-tokenizer \
  php-xml \
  php-xmlreader \
  php-xmlwriter \
  php-zip \
  && rm -rf /var/cache/apk/* \
  && rm -rf /tmp/*

RUN apk --no-cache add \
  postgresql-libs \
  postgresql-dev \
  && docker-php-ext-install \
#    pdo \
    pgsql \
    pdo_pgsql \
  && apk del postgresql-dev \
  && rm -rf /var/cache/apk/* \
  && rm -rf /tmp/*

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm", "--nodaemonize"]
