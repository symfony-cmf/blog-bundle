<?php

$container->setParameter('cmf_testing.bundle_fqn', 'Symfony\Cmf\Bundle\BlogBundle');
$loader->import(CMF_TEST_CONFIG_DIR.'/default.php');
$loader->import(CMF_TEST_CONFIG_DIR.'/phpcr_odm.php');
$loader->import(CMF_TEST_CONFIG_DIR.'/sonata_admin.php');
$loader->import(__DIR__.'/blogbundle.yml');
