<?php
/**
 * params-private.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 5:51 PM
 */
return array(
	'env.code' => 'prod',
    
    'urlManager.hostInfo'=>'http://itake.me',
    'urlManager.secureHostInfo'=>'https://itake.me',
    'urlManager.secureRoutes'=>array(
        'user/login',
        'user/register',
        'user/changePassword',
        'user/forgetPassword'
    )
);