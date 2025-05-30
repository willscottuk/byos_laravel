########################
# Base Image
########################
FROM bnussbau/serversideup-php:8.3-fpm-nginx-alpine-imagick-chromium AS base

LABEL org.opencontainers.image.source=https://github.com/usetrmnl/byos_laravel
LABEL org.opencontainers.image.description="TRMNL BYOS Laravel"
LABEL org.opencontainers.image.licenses=MIT

ARG APP_VERSION
ENV APP_VERSION=${APP_VERSION}

ENV AUTORUN_ENABLED="true"

# Switch to the root user so we can do root things
USER root

# Set the working directory
WORKDIR /var/www/html

# Copy the application files
COPY --chown=www-data:www-data . /var/www/html
COPY --chown=www-data:www-data .env.example .env

# Install the composer dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

########################
# Assets Image
########################
FROM node:22-alpine AS assets

# Copy the application
COPY --from=base /var/www/html /app

# Set the working directory
WORKDIR /app

# Install the node dependencies and build the assets
RUN npm ci --no-audit \
    && npm run build

########################
# Production Image
########################
FROM base AS production

# Copy the assets from the assets image
COPY --chown=www-data:www-data --from=assets /app/public/build /var/www/html/public/build
COPY --chown=www-data:www-data --from=assets /app/node_modules /var/www/html/node_modules

# Drop back to the www-data user
USER www-data
