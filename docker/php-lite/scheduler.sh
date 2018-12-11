#!/bin/bash
echo "Scheduler Start"
while [ true ]
do
php /var/www/artisan schedule:run --verbose &
sleep 60
done
