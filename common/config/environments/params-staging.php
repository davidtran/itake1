<?php

/**
 * params-prod.php
 *
 * Common parameters for the application on production
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 1:41 PM
 */
/**
 * Replace following tokens for correspondent configuration data
 *
 * {DATABASE-NAME} ->   database name
 * {DATABASE-HOST} -> database server host name or ip address
 * {DATABASE-USERNAME} -> user name access
 * {DATABASE-PASSWORD} -> user password
 *
 * {DATABASE-TEST-NAME} ->   Test database name
 * {DATABASE-TEST-HOST} -> Test database server host name or ip address
 * {DATABASE-USERNAME} -> Test user name access
 * {DATABASE-PASSWORD} -> Test user password
 */
return array(
    'env.code' => 'prod',
    // DB connection configurations
    'db.name' => '',
    'db.connectionString' => 'mysql:host=127.0.0.1;dbname=itake',
    'db.username' => 'itake',
    'db.password' => 'itake',
    'db.tablePrefix' => 'mp_',
    'email.host' => 'smtp.gmail.com',
    'email.username' => 'rubickweb',
    'email.password' => 'goodmorning2013',
    'email.port' => 465,
    'email.adminEmail' => 'rubickweb@gmail.com',
    'email.encryption' => 'ssl',
    'facebook.appId' => '221643951240412',
    'facebook.secret' => '4d38bec6cc561750041e4fc64eaab141',
    'solr.port' => '8983',
    'solr.host' => 'localhost',
    'solr.indexPath' => '/solr',
    'country.default' => 'us',
    'urlManager.hostInfo' => 'http://test.itake.me',
    'urlManager.secureHostInfo' => 'https://test.itake.me',
    'urlManager.secureRoutes' => array(
    ),
    'backendUrl'=>'http://backend-test.itake.me',
    'frontendUrl'=>'http://test.itake.me',
);
