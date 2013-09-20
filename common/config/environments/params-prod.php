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
 * {DATABASE-NAME} ->   database name
 * {DATABASE-HOST} -> database server host name or ip address
 * {DATABASE-USERNAME} -> user name access
 * {DATABASE-PASSWORD} -> user password
 *
 * {DATABASE-TEST-NAME} ->   Test database name
 * {DATABASE-TEST-HOST} -> Test database server host name or ip address
 * {DATABASE-USERNAME} -> Test user name access
 * {DATABASE-PASSWORD} -> Test user password
 */
return array(
    'env.code' => 'prod',
    // DB connection configurations
    'db.name' => '',
    'db.connectionString' => 'mysql:host=localhost;dbname=itake',
    'db.username' => 'root',
    'db.password' => 'itake1234',
    'db.tablePrefix' => 'mp_',
    'db.schemaCachingDuration'=>3600,
    
    'email.host' => 'localhost',
    'email.username' => 'norely',
    'email.password' => 'goodmorning2013',
    'email.port' => 25,
    'email.adminEmail' => 'norely@itake.me',
    'email.encryption' => false,
    'facebook.appId' => '620447237967845',
    'facebook.secret' => '5b14e9c48eaf0da3ead75e49df09c882',
    'solr.port' => '8983',
    'solr.host' => 'localhost',
    'solr.indexPath' => '/solr',
    'country.default' => 'vn',
    'urlManager.hostInfo' => 'http://itake.me',
    'urlManager.secureHostInfo' => 'https://itake.me',
    'urlManager.secureRoutes' => array(
        'user/login',
        'user/register',
        'user/changePassword',
        'user/forgetPassword'
    ),
    'backendUrl'=>'http://backend.itake.me',
    'frontendUrl'=>'http://itake.me',
);
