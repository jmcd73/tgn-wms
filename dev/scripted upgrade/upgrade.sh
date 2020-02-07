#!/bin/sh
DB_NAME=pallets1
DB_USER=root
DB_UPDATE_USER=palletsUpgradeUser
DB_HOST=host.docker.internal
DB_BACKUP=pallets-snapshot-202001241119.sql.gz
CAKE_CONNECTION=pallets1

# run this script from `dev/scripted upgrades`
# cake db config
# the cake connection as listed in app/Config/database.php
MYSQL_CONFIG=palletsTest

mysql_config_editor set --login-path=$MYSQL_CONFIG --host=$DB_HOST --user=$DB_USER --password

sed -e "s/{{DB_NAME}}/$DB_NAME/g" -e "s/{{DB_USER}}/$DB_UPDATE_USER/g" sql/03-createDBUser.sql | mysql --login-path=$MYSQL_CONFIG -h $DB_HOST -u $DB_USER

zcat sql/$DB_BACKUP | mysql --login-path=$MYSQL_CONFIG --default-character-set=utf8mb4 -h $DB_HOST -u $DB_USER $DB_NAME

# delete cache files
find ../../app/tmp/ -type f -delete

# Console/cake schema generate -f -c base
# Console/cake schema generate -f -c default -s 1
# Console/cake schema generate -f -c default -s 2

for i in 1 2 3 4 5; do
    echo y | ../../app/Console/cake schema update -c $CAKE_CONNECTION -f -s $i
done

for i in $(ls -1 sql/*.sql | grep -v 03-createDBUser.sql); do
    echo Applying $i to $DB_NAME
    mysql --login-path=$MYSQL_CONFIG -h $DB_HOST -u $DB_USER $DB_NAME <$i
done
