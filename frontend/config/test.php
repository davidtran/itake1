<?php
/**
 * test.php
 *
 * configuration file for testing
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/24/12
 * Time: 8:08 AM
 */
return CMap::mergeArray(
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'main.php'),
	array(
		'components' => array(
            'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                array(
                    'class' => 'application.extensions.pqp.PQPLogRoute',
                    'categories' => 'application.*, exception.*',
                ),
            ),
        ),
        'db'=>array(          
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager'
			),
			/* uncomment if we require to run commands against test database */
			/*
			 'db' => array(
				'connectionString' => $params['testdb.connectionString'],
				'username' => $params['testdb.username'],
				'password' => $params['testdb.password'],
				'charset' => 'utf8'
			),
			*/

		)
	)
);