FROM webdevops/php-nginx:8.2-alpine

ENV PUID=1000
ENV PGID=1000
ENV USERNAME=application

ENV APP_HOME=/app
ENV CONFIG_HOME=/config
ENV WEB_DOCUMENT_ROOT=$APP_HOME/public

# Install system dependencies
RUN apk add oniguruma-dev postgresql-dev libxml2-dev nodejs yarn

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY /docker-entrypoint.sh /entrypoint.d

# Set working directory
WORKDIR $APP_HOME

COPY . .

# Change owner
RUN chown -R ${USERNAME}:${USERNAME} $APP_HOME

VOLUME ["/config"]
