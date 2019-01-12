#!/usr/bin/env bash
#composer install --no-dev -o -a
php bin/console doctrine:migrations:migrate -n
php bin/console cache:clear
php bin/console cache:warmup
