<?php
/**
 * params-private.php
 *
 * Common parameters for the application on private -your local environment
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
	'env.code' => 'private',
	// DB connection configurations
	'db.name' => '',
	'db.connectionString' => 'mysql:host=localhost;dbname=itake',
	'db.username' => 'root',
	'db.password' => '',
    'db.tablePrefix'=>'mp_',
    'db.schemaCachingDuration'=>false,
    'email.host'=>'smtp.gmail.com',
    'email.username'=>'rubickweb',
    'email.password'=>'goodmorning2013',
    'email.port'=>465,
    'email.adminEmail'=>'rubickweb@gmail.com',
    'email.encryption'=>'ssl',
    'email.viewPath'=>'frontend.views.mail',
    
    'facebook.appId'=>'343485335785351',
    'facebook.secret'=>'e77260e49968b3d74b2efe8577893d66',
    
    'solr.port'=>'8983',
    'solr.host'=>'localhost',
    'solr.indexPath'=>'/solr',
    'country.default'=>'vn',
    
    'urlManager.hostInfo'=>'http://dev.itake',
    'urlManager.secureHostInfo'=>'https://dev.itake',
    'urlManager.secureRoutes'=>array(
       
    ),
    'backendUrl'=>'http://backend.itake',
    'frontendUrl'=>'http://dev.itake',
);