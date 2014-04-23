#!/bin/bash

cd /home/web/prod/www/
git checkout master
git pull origin master >> /home/deploy/deploy.log
echo "" >> /home/deploy/deploy.log
