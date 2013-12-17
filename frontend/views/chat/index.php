<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->baseUrl . '/css/chat.css');
?>
<div id='message'>
<ul class="userList" style="visibility: visible;"></ul>

<div class="chatContainer">
    <div class="title">
        <span class="friend">my friend</span>
        <a href="#" class="closeWin"><img src="<?php echo Yii::app()->getBaseUrl(true) . DIRECTORY_SEPARATOR . 'images/close.png'?>"/></a>
    </div>
    <div class="chat"></div>
    <div class="message">
        <input placeholder="Type your message" type="text" class="msg" />
    </div>
</div>
<?php
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/chat/app.js', CClientScript::POS_END);
?>
<script type="text/javascript">
var user_username = '<?php echo User::model()->findByPk(Yii::app()->user->id)->username;?>';
var user_userid = '<?php echo Yii::app()->user->id;?>';
var baseUrl = '<?php echo Yii::app()->getBaseUrl(true);?>';
</script>
<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>:7777/socket.io/socket.io.js"></script>
</div>