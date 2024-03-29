<?php
/**
 * main.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 5:48 PM
 */
return array(
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
        )
    ),
    'components' => array( 
    'log'=>array(
    			'class' => 'CLogRouter',		
                'routes'=>array(
                        array(
                            'class'=>'common.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
                        ),
                   ),   
                ),
    'db' => array(
    			'enableProfiling'=>true,
                'enableParamLogging'=>true,
    		),
    ),     
);
