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
    'api.checkToken'=>true,
    'upload.maxImageNumber'=>4,
    'request.baseUrl' => 'http://dev.itake', 
    'showSortTab'=>false,
    'postLimitPerDay'=>5,
    'postImageMaxSize'=>3145728,
    
    //increase this number to remove all js, css cache of browser
    'clientScript.incrementNumber'=>2,
);