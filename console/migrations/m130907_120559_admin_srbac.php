<?php

class m130907_120559_admin_srbac extends CDbMigration
{


   
      public function safeUp()
      {
           $this->execute('drop table if exists AuthAssignment;
drop table if exists AuthItemChild;
drop table if exists AuthItem;

create table AuthItem
(
   name                 varchar(64) not null,
   type                 integer not null,
   description          text,
   bizrule              text,
   data                 text,
   primary key (name)
);

create table AuthItemChild
(
   parent               varchar(64) not null,
   child                varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references AuthItem (name) on delete cascade on update cascade,
   foreign key (child) references AuthItem (name) on delete cascade on update cascade
);

create table AuthAssignment
(
   itemname             varchar(64) not null,
   userid               varchar(64) not null,
   bizrule              text,
   data                 text,
   primary key (itemname,userid),
   foreign key (itemname) references AuthItem (name) on delete cascade on update cascade
);');
        $this->execute('alter table {{user}} add column role int(11)');
        /* @var $auth CAuthManager */
        $auth = Yii::app()->authManager;

        $mod = $auth->createRole('mod', 'view/delete product', 'return Yii::app()->user->model->role == UserRoleConstant::MOD');
        $viewProduct = $auth->createAuthItem('viewProduct', CAuthItem::TYPE_TASK);
        $deleteProduct = $auth->createAuthItem('deleteProduct', CAuthItem::TYPE_TASK);
        $mod->addChild('viewProduct');
        $mod->addChild('deleteProduct');

        $admin = $auth->createRole('admin', 'view/delete product, manage user', 'return Yii::app()->user->model->role == UserRoleConstant::ADMIN');
        $viewUser = $auth->createTask('viewUser');
        $createUser = $auth->createAuthItem('createUser', CAuthItem::TYPE_TASK);
        $updateUser = $auth->createTask('updateUser');
        $deleteUser = $auth->createTask('deleteUser');
        $admin->addChild('createUser');
        $admin->addChild('updateUser');
        $admin->addChild('deleteUser');
        $admin->addChild('viewUser');
        $admin->addChild('mod');
        return true;
      }

      public function safeDown()
      {
          return false;
      }
    
}