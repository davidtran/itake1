<?php

/**
 * params-private.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 5:51 PM
 */
return array(
    'env.code' => 'private',
    'api.checkToken' => false,
    'request.baseUrl' => 'http://dev.itake', 
    'upload.maxImageNumber' => 4,
    'showSortTab'=>true,
    'postLimitPerDay'=>99,
    'postImageMaxSize'=>3145728,
    /*
     * Increment number is appended after $url so the script wont be cache
     */
    'clientScript.incrementNumber'=>1,
);