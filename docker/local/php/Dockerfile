FROM php:8.1.0-fpm

ENV TZ=America/Sao_Paulo

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN rm /etc/apt/preferences.d/no-debian-php && \
    apt-get update -yqq && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
    git \
    wget \
    curl \
    unzip \
    zip \
    openssl \
    libpq-dev \
    libaio1 \
    libaio-dev \
    zlib1g-dev \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    libmemcached-dev && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql && \
    docker-php-ext-configure intl && \
      pecl install redis && \
      pecl install apcu && \
      pecl install xdebug && \
    docker-php-ext-install \
      intl \
      zip \
      mbstring \
      pcntl \
      sockets \
      exif \
      pgsql \
      pdo_pgsql && \
    docker-php-ext-enable \
      redis \
      opcache \
      xdebug \
      apcu && \
    pecl clear-cache

RUN curl -L -C - --progress-bar -o /usr/local/bin/composer https://getcomposer.org/composer.phar && \
    chmod 755 /usr/local/bin/composer && \
    useradd -m devs && \
    usermod -u 1000 devs

RUN composer self-update

COPY --chown=devs:www-data ../.. /var/www

RUN chown -R www-data /var/www

USER devs

EXPOSE 9000
EXPOSE 9003
EXPOSE 9191

CMD ["php-fpm"]
