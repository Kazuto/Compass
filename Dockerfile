FROM webdevops/php-nginx:8.2-alpine

ENV PUID=1000
ENV PGID=1000
ENV USERNAME=application

ENV APP_HOME=/app
ENV WEB_DOCUMENT_ROOT=$APP_HOME/public

# Install system dependencies
RUN apk add oniguruma-dev postgresql-dev libxml2-dev nodejs yarn

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Set working directory
WORKDIR $APP_HOME

COPY . .
COPY ./.env.docker $APP_HOME/.env

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Initialize Laravel
RUN php artisan key:generate --force && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan compass:setup && \
    yarn install && yarn build && \
    rm -rf node_modules

# Optimize Laravel Instance
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan optimize

# Change owner
RUN chown -R ${USERNAME}:${USERNAME} $APP_HOME

VOLUME /app/database
