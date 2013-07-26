<?php
$frontendConfigDir = dirname(__FILE__);

$root = $frontendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$params = require_once($frontendConfigDir . DIRECTORY_SEPARATOR . 'params.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
Yii::setPathOfAlias('www', $root . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'www');

$mainLocalFile = $frontendConfigDir . DIRECTORY_SEPARATOR . 'main-local.php';
$mainLocalConfiguration = file_exists($mainLocalFile) ? require($mainLocalFile) : array();

$mainEnvFile = $frontendConfigDir . DIRECTORY_SEPARATOR . 'main-env.php';
$mainEnvConfiguration = file_exists($mainEnvFile) ? require($mainEnvFile) : array();

return CMap::mergeArray(
                array(
            'basePath' => 'frontend',
            'params' => $params,
            'preload' => array('log', 'bootstrap'),
            'language' => 'vi',
            'import' => array(
                'common.components.*',
                'common.extensions.*',
                'common.models.*',
                'common.utils.*',
                'common.utils.solr.*',
                'application.components.*',
                'application.controllers.*',
                'application.models.*'
            ),
            'name' => 'iTake.me',
            'components' => array(
                'errorHandler' => array(
                    'errorAction' => 'site/error'
                ),
                'bootstrap' => array(
                    'class' => 'common.extensions.bootstrap.components.Bootstrap',
                    'responsiveCss' => true,
                ),
                'clientScript' => array(
                    'scriptMap' => array(
                        'jquery.js' => false,
                        'jquery.min.js' => false,
                    )
                ),
                'user' => array(
                    // enable cookie-based authentication
                    'allowAutoLogin' => true,
                    'class' => 'application.components.WebUser',
                ),
                'facebook' => array(
                    'appId' => $params['facebook.appId'],
                    'secret' => $params['facebook.secret'],
                    'class' => 'common.extensions.yii-facebook-opengraph.MyFacebook',
                    'fileUpload' => true,
                ),
                // uncomment the following to enable URLs in path-format
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'caseSensitive' => false,
                    'rules' => array(
                        'rao/<id:\d+>/<title:.*?>' => '/product/details',
                        'dang-ky' => 'user/register',
                        'dang-nhap' => 'user/login',
                        'danh-muc/<category:\d+>/<name:.*?>' => '/site/category',
                        'chon-thanh-pho/<id:\d+>/<name:.*?>' => 'site/city',
                        'dang-tin/<category:\d+>/<name:.*?>' => '/upload/uploadNew',
                    ),
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
                        'encryption' => 'ssl',
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
            /* make sure you have your cache set correctly before uncommenting */
            /* 'cache' => $params['cache.core'], */
            /* 'contentCache' => $params['cache.content'] */
            ),
                ), CMap::mergeArray($mainEnvConfiguration, $mainLocalConfiguration)
);
