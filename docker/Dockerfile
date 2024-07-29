FROM php:8.2-apache

ENV DEBIAN_FRONTEND noninteractive

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    \
    &&  apt-get update \
    &&  apt-get install -y --no-install-recommends \
    locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip \
    \
    &&  echo "en_US.UTF-8 UTF-8" > /etc/locale.gen  \
    &&  echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    &&  locale-gen \
    \
    &&  curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer \
    \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash \
    && apt-get install -y --no-install-recommends nodejs \
    \
    &&  curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin \
    \
    &&  docker-php-ext-configure \
    intl \
    &&  docker-php-ext-install \
    pdo pdo_mysql opcache intl zip calendar dom mbstring gd xsl \
    \
    &&  pecl install apcu && docker-php-ext-enable apcu

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN a2enmod rewrite && a2enmod ssl && a2enmod socache_shmcb
RUN mkdir -p /etc/apache2/ssl

COPY ./ssl/mycert.crt /etc/apache2/ssl/mycert.crt
COPY ./ssl/mycert.key /etc/apache2/ssl/mycert.key

RUN a2enmod proxy && a2enmod proxy_http
RUN a2ensite default-ssl
RUN apt-get update && apt-get upgrade -y

# COPY ./vhosts/vhosts.conf /etc/apache2/sites-available/vhosts.conf

EXPOSE 80
EXPOSE 443

RUN git config --global user.email "gerin.patrice@yahoo.fr" \
    &&  git config --global user.name "patrice"

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

WORKDIR /var/www/project/app
