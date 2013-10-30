<?php

$cs = Yii::app()->clientScript;
Yii::app()->clientScript->registerScriptFile('//maps.google.com/maps/api/js?sensor=false', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/dupload.js', CClientScript::POS_END);

$cityList = json_encode(CityUtil::getCityList(true));
$contactInfo = json_encode(UserUtil::getContactInfo());
$cs->registerScript('product info', "    
    var cityList = $cityList;
    var contactInfo = $contactInfo;
        "   
        , CClientScript::POS_HEAD);
?>
<div class="row-fluid">
<?php
$this->widget('ext.xupload.XUpload', array(
                    'url' => Yii::app()->createUrl("upload/upload"),
                    'model' => $model,                    
                    'attribute' => 'file',
                    'multiple' => true,
));
?>
</div>