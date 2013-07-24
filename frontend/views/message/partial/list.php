<div id="messageListContainer">
    <?php foreach($messageList as $message):?>
    <div class="messageItemContainer" class="<?php if($message['read']) echo 'read'; ?>">
        <div class="row-fluid">
            <div class="span1">
                <?php echo CHtml::image(UserUtil::getProfileImageUrl($message['friend'])); ?>
            </div>
            <div class="span9">
                <div class="messageContent">
                    <?php echo StringUtil::limitByWord($message['content'], 50); ?>
                </div>
                <div class="messageTime">
                    <?php echo DateUtil::elapseTime($message['time']); ?>
                </div>
            </div>
            <div class="span2">
                <?php echo CHtml::link('Xem',array(
                    '/message/conversation','friendId'=>$message['friend']->id
                ),array(
                    'class'=>'btnViewMessage btn btn-primary',
                    'data-friend-id'=>$message['friend']->id
                )); ?>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
</div>