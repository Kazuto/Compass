#!/usr/bin/env bash

cd ..

need_key=false
need_migration=false
symlinks=(
    $APP_HOME/storage/logs
    $APP_HOME/database/database.sqlite
    $APP_HOME/.env
)

if [[ ! -d $CONFIG_HOME/logs ]]; then
    echo "Creating log directory"
    mkdir -p $CONFIG_HOME/logs
fi

if [[ ! -f $CONFIG_HOME/.env ]]; then
    echo "Creating .env"
    cp $APP_HOME/.env.docker $CONFIG_HOME/.env

    need_key=true
fi

if [[ ! -f $CONFIG_HOME/database.sqlite ]]; then
    echo "Creating database"
    touch $CONFIG_HOME/database.sqlite

    need_migration=true
fi

for i in "${symlinks[@]}"; do
    if [[ -e "${i}" && ! -L "${i}" ]]; then
        rm -rf "${i}"
    fi
    if [[ ! -L "${i}" ]]; then
        ln -s $CONFIG_HOME/"$(basename "${i}")" "${i}"
    fi
done

echo "Setting up permissions"
chown -R $USERNAME:$USERNAME $CONFIG_HOME

cd $APP_HOME

if [ "$need_key" = true ]; then
    echo "Creating app key. This may take a while on slower systems"
    php artisan key:generate
fi

echo "Optimize Laravel Instance"
php artisan icon:cache
php artisan view:cache
php artisan optimize

if [ "$need_migration" = true ]; then
    echo "Migrating database"
    php artisan migrate --force

    echo "Creating User"
    php artisan compass:setup
fi
