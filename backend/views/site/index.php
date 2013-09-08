<?php $this->pageTitle=Yii::app()->name; ?>

<h1>iTake dashboard</h1>

<ul>
    <li><?php echo CHtml::link('Quản lý người dùng','/user'); ?></li>
    <li><?php echo CHtml::link('Quản lý bài đăng','/product'); ?></li>
</ul>