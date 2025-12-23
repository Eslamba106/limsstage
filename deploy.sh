#!/bin/bash

PROJECT_DIR="/var/www/html"

BRANCH="master"


cd $PROJECT_DIR || exit


if [ ! -d ".git" ]; then
    echo "This is not a git repository."
    exit 1
fi


git fetch origin $BRANCH
git reset --hard origin/$BRANCH

chown -R www-data:www-data $PROJECT_DIR
find $PROJECT_DIR -type d -exec chmod 755 {} \;
find $PROJECT_DIR -type f -exec chmod 644 {} \;

echo "Deployment finished at $(date)"

