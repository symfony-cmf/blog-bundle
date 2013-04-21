#!/bin/bash

composer install --dev
cp ./Tests/Functional/app/config/parameters.yml.dist ./Tests/Functional/app/config/parameters.yml
php Tests/Functional/app/console doctrine:phpcr:init:dbal
php Tests/Functional/app/console doctrine:phpcr:register-system-node-types
