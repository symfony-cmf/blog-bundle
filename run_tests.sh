#!/bin/sh
sh vendor/symfony-cmf/testing/bin/travis/doctrine_orm.sh
sh vendor/symfony-cmf/testing/bin/travis/phpcr_odm_doctrine_dbal.sh
bin/phpunit

