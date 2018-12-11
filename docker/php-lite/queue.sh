#!/bin/bash
echo "Queue Start"
php /var/www/artisan queue:work --verbose --tries=3 --timeout=90
