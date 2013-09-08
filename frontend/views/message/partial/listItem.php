<div class="messageItemContainer" class="<?php if ($item['read']) echo 'read'; ?>">
    <div class="row-fluid">
        <div class="span1">
            <?php echo CHtml::image($item['friend']->getProfileImageUrl()); ?>
        </div>
        <div class="span9">
            <div class="messageContent">
                <?php echo StringUtil::limitByWord($item['content'], 50); ?>
            </div>
            <div class="messageTime">
                <?php echo DateUtil::elapseTime($item['time']); ?>
            </div>
        </div>
        <div class="span2">
            <?php
            echo CHtml::link('Xem', array(
                '/message/conversation', 'friendId' => $item['friend']->id
                    ), array(
                'class' => 'btnViewMessage btn btn-primary',
                'data-friend-id' => $item['friend']->id
            ));
            ?>
        </div>
    </div>
</div>