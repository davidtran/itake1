<?php

class FacebookPostQueueUtil
{

    const MAX_ATTEMPS = 3;

    public static function queueCommand($command, $type, $params, $userId, $checkUnique = true)
    {
        //make the hash
        //check if hash exist
        //if exist, return. If not: save the command
        $hash = self::makeHash($command, $type, $params, $userId);
        $exist = Yii::app()->db->createCommand('select count(*) from {{facebook_queue}} where hash=:hash')->queryScalar(array(
            'hash' => $hash
        ));
        if (($exist == 0 && $checkUnique ) || !$checkUnique) {
            $model = new FacebookQueue();
            $model->command = $command;
            $model->type = $type;
            $model->params = serialize($params);
            $model->user_id = $userId;
            $model->success = 0;
            $model->status = FacebookQueue::STATUS_FRESH;
            $model->hash = $hash;
            $model->save();
        }
        return false;
    }

    public static function processQueueList()
    {
        $models = FacebookQueue::model()->findAll(array(
            'condition' => '(success = 0 && (status=:fresh || status=:refreshed) && status != :stopped) ',
            'params' => array(
                'fresh' => FacebookQueue::STATUS_FRESH,
                'refreshed' => FacebookQueue::STATUS_REFRESHED,
                'stopped' => FacebookQueue::STATUS_STOPPED
            ),
            'order' => 'create_date'
        ));
        foreach ($models as $model) {
            try
            {
                $params = unserialize($model->params);
                $accessToken = FacebookUtil::getInstance()->getSavedUserToken($model->user_id);
                $params['access_token'] = $accessToken;
                self::postByCurl($model->command, $model->type, $params);
                $model->success = 1;
                $model->success_date = date('Y-m-d H:i:s');
                $model->save();
            }
            catch (Exception $e)
            {
                Yii::log($e->getMessage(), 'error', 'facebook');
                if ($model->status == FacebookQueue::STATUS_FRESH) {
                    $model->status = FacebookQueue::STATUS_WAIT; // wait for a new access_token
                }
                else if ($model->status == FacebookQueue::STATUS_REFRESHED) {
                    $model->status = FacebookQueue::STATUS_STOPPED; //no need to run this command
                }
                $model->save();
            }
        }
    }

    protected static function makeHash($command, $type, $params, $userId)
    {
        $paramString = serialize($params);
        $uniqueParams = "$command-$type-$paramString-$userId";
        return md5($uniqueParams);
    }

    public static function refreshFacebookCommandForUser($userId)
    {
        Yii::app()->db->createCommand()->update(
                '{{facebook_queue}}', array(
            'status' => FacebookQueue::STATUS_REFRESHED
                ), 'user_id=:userId and status=:wait', array(
            'userId' => $userId,
            'wait' => FacebookQueue::STATUS_WAIT,
        ));
    }

    public static function postByCurl($command, $type, $params)
    {
        $postData = http_build_query($params, '', '&');
        $graph_url = "https://graph.facebook.com/" . $command . '?';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        if(strtolower($type) == 'post'){
            curl_setopt($ch, CURLOPT_PORT, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
        }else{
            
        }
        $graph_url.=$postData;
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);    
        $output = CJSON::decode($output);
//        var_dump($output);
        if(isset($output['error'])){
            throw new CException('Facebook API Error '.$output['error']['message'].' - '.$output['error']['code']);
        }
        
    }

}
