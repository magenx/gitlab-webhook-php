#!/bin/bash

cd /home/web/devel/www/
git checkout devel
git pull origin devel >> /home/deploy/deploy.log
echo "" >> /home/deploy/deploy.log
