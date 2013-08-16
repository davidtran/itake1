<?php
include_once 'XUploadAction.php';
class ITakeXUploadAction extends XUploadAction{
    public function init()
    {
        $userFiles = Yii::app()->user->getState($this->stateVariable, array());
        if(count($userFiles) > Yii::app()->params['upload.maxImageNumber']){
            echo json_encode(
                    array(
                        array(
                            "error" => Yii::t('xupload.widget','Max number of files exceeded'),
                            )
                        )
                    );
            exit;
        }
        return parent::init();
    }
}
