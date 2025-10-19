#!/bin/bash
set -euo pipefail
php -r "copy('https://getcomposer.org/installer','composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php
composer --version
# instalar dependências do projeto já presente em /var/www/html
cd /var/www/html
composer install --no-interaction --prefer-dist
composer dump-autoload -o
echo "COMPOSER_DONE"
