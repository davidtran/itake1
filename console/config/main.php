sd<?php
/**
 * main.php
 *
 * Configuration file for console applications
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 12:15 PM
 */
$consoleConfigDir = dirname(__FILE__);

$root = $consoleConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$params = require_once($consoleConfigDir . DIRECTORY_SEPARATOR . 'params.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('console', $root . DIRECTORY_SEPARATOR . 'console');
Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
/* uncomment if the following aliases are required */
//Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
//Yii::setPathOfAlias('backend', $root . DIRECTORY_SEPARATOR . 'backend');

$mainLocalFile = $consoleConfigDir . DIRECTORY_SEPARATOR . 'main-local.php';
$mainLocalConfiguration = file_exists($mainLocalFile) ? require($mainLocalFile) : array();

$mainEnvFile = $consoleConfigDir . DIRECTORY_SEPARATOR . 'main-env.php';
$mainEnvConfiguration = file_exists($mainEnvFile) ? require($mainEnvFile) : array();

return CMap::mergeArray(
                array(
            // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
            'basePath' => 'console',
            // set parameters
            'params' => $params,
            // preload components required before running applications
            // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
            'preload' => array('log'),
            // setup import paths aliases
            // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
            'import' => array(
                'console.components.*',
                'common.components.*',
                'common.extensions.*',
                'common.models.*',
                'common.utils.*',
                'common.utils.solr.*',
                'application.components.*',
                'application.controllers.*',
                'application.models.*',
            ),
            /* locate migrations folder if necessary */
            'commandMap' => array(
                'migrate' => array(
                    'class' => 'system.cli.commands.MigrateCommand',
                    /* change if required */
                    'migrationPath' => 'root.console.migrations'
                )
            ),
            'components' => array(
                'errorHandler' => array(
                    // @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
                    'errorAction' => 'site/error'
                ),
                'authManager' => array(
                    'class' => 'CDbAuthManager',
                    'connectionID' => 'db',
                ),
                'request'=>array(
                    'baseUrl'=>$params['request.baseUrl']
                ),
                'urlManager' => array(
                    'baseUrl' => $params['urlManager.hostInfo'],
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'caseSensitive' => false,
                    'urlSuffix' => '.html',
                ),
                'user' => array(
                    // enable cookie-based authentication
                    'allowAutoLogin' => true,
                    'class' => 'application.components.WebUser',
                ),
                'facebook' => array(
                    'appId' => $params['facebook.appId'],
                    'secret' => $params['facebook.secret'],
                    'class' => 'common.extensions.yii-facebook-opengraph.ItakeSFacebook',
                    'fileUpload' => true,
                ),
                'mail' => array(
                    'class' => 'common.extensions.yii-mail.YiiMail',
                    'transportType' => 'smtp',
                    'viewPath' => $params['email.viewPath'],
                    'logging' => true,
                    'dryRun' => false,
                    'transportOptions' => array(
                        'host' => $params['email.host'],
                        'username' => $params['email.username'],
                        'password' => $params['email.password'],
                        'port' => $params['email.port'],
                        'encryption' => $params['email.encryption'],
                    )
                ),
                'solrProduct' => array(
                    'class' => 'common.extensions.solr.CSolrComponent',
                    'host' => $params['solr.host'],
                    'port' => $params['solr.port'],
                    'indexPath' => $params['solr.indexPath'],
                ),
                'errorHandler' => array(
                    // use 'site/error' action to display errors
                    'errorAction' => 'site/error',
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, warning',
                        ),
                    ),
                ),
                'db' => array(
                    'connectionString' => $params['db.connectionString'],
                    'username' => $params['db.username'],
                    'password' => $params['db.password'],
                    'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
                    'enableParamLogging' => YII_DEBUG,
                    'charset' => 'utf8',
                    'tablePrefix' => $params['db.tablePrefix'],
                ),
                'cache' => $params['cache.core'],
                'contentCache' => $params['cache.content']
            ),
                ), CMap::mergeArray($mainEnvConfiguration, $mainLocalConfiguration)
);

