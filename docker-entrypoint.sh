#!/usr/bin/env bash

cd ..

function info {
    printf "\n[INFO] $1 \n"
}

need_key=false
fresh_install=false

symlinks=(
    $APP_HOME/storage/logs
    $APP_HOME/database/database.sqlite
    $APP_HOME/theme.config.json
    $APP_HOME/.env
)

if [[ ! -d $CONFIG_HOME/logs ]]; then
    info "Creating Log Directory"
    mkdir -p $CONFIG_HOME/logs
fi

if [[ ! -f $CONFIG_HOME/.env ]]; then
    info "Creating .env"
    cp $APP_HOME/.env.docker $CONFIG_HOME/.env

    need_key=true
fi

if [[ ! -f $CONFIG_HOME/database.sqlite ]]; then
    info "Creating Database"
    touch $CONFIG_HOME/database.sqlite

    fresh_install=true
fi

if [[ ! -f $CONFIG_HOME/theme.config.json ]]; then
    info "Creating Theme Config"
    cp $APP_HOME/theme.config.example.json $CONFIG_HOME/theme.config.json
fi

for i in "${symlinks[@]}"; do
    if [[ -e "${i}" && ! -L "${i}" ]]; then
        rm -rf "${i}"
    fi
    if [[ ! -L "${i}" ]]; then
        ln -s $CONFIG_HOME/"$(basename "${i}")" "${i}"
    fi
done

cd $APP_HOME

if [ "$need_key" = true ]; then
    info "Generating Encryption Key"
    php artisan key:generate --quiet
fi

info "Optimizing Application"
php artisan icon:cache --quiet
php artisan view:cache --quiet
php artisan optimize --quiet

info "Migrating Database"
php artisan migrate --force --quiet

if [ "$fresh_install" = true ]; then
    info "Creating User"
    php artisan compass:setup
fi

info "Setting Up Permissions"
chown -R $USERNAME:$USERNAME $APP_HOME

printf "\nAll Done!\n\n"
