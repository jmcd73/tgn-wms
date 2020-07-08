#!/bin/bash

function checkMysqlConfig() {
    CONFIG_EDITOR=mysql_config_editor
    [ ! -x "$(command -v $CONFIG_EDITOR)" ] && (
        echo "Error: \"$CONFIG_EDITOR\" not found. Exiting..."
        exit 1
    )
    MSQL_CONFIG=$($CONFIG_EDITOR print --login-path=$1)
    echo "Config: \"$MSQL_CONFIG\""
    if [ -z "$MSQL_CONFIG" ]; then
        echo "Missing Config"
        exit 1
    fi
}

function backupDb() {
    BACKUP_DIR_TARGET=$HOME/pallets-backup-custom
    MYSQL=/usr/bin/mysqldump
    DATE_STAMP=$(date '+%Y%m%d%H%M')
    BACKUP_LOGIN_PATH=wmsBackupAlias
    checkMysqlConfig $BACKUP_LOGIN_PATH
    $MYSQL --login-path=$BACKUP_LOGIN_PATH --opt $1 | gzip -c > $BACKUP_DIR_TARGET/${1}-snapshot-${DATE_STAMP}.sql.gz
}

function but() {
    backupDb 'pallets'
}

function bul() {
    backupDb 'palletsTest'
}

