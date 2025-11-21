ARG PHP_VERSION
FROM php:${PHP_VERSION}cli

# Increase memory limit
RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN <<EOF
set -eux
apt-get update
apt-get install --yes git zip
rm -rf /var/lib/apt/lists/*
EOF

# Install Xdebug
ARG XDEBUG_ENABLED
RUN <<EOF
if [ $XDEBUG_ENABLED -eq 1 ]; then
    pecl install xdebug
    docker-php-ext-enable xdebug
fi
EOF

# Sort out git
RUN git config --global --add safe.directory /app
WORKDIR /app
