<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $thisname
 * @property string $password
 * @property string $salt
 * @property string $create_date
 * @property string $update_date
 * @property integer $type
 * @property integer $level     
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $website
 * @property string $image  
 * @property integer $status     
 */
class User extends CActiveRecord
{   
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_NOT_SPECIFY = 0;
    const TYPE_NORMAL = 0;
    const TYPE_ADMIN = 1;
    const DEFAULT_POST_LIMIT = 3;
    public $sendRegisterEmail = true;
    public $uploadImage;
    public $registerFromMobile = false;
    public $lastMessageContent;
    public $lastMessageDate;
    public $lastIsRead;
    public $captcha;
    public $allowUpdateWithoutCaptcha = false;

    // public $oldPassword;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        
        return array(
            array('email,username,password', 'required'),
            array('email', 'unique', 'className' => 'User', 'attributeName' => 'email'),
            array('post_limit,status,type,isFbUser,gender,role', 'numerical', 'integerOnly' => true),
            array('password', 'length', 'max' => 50),
            array('salt', 'length', 'max' => 50),
            array('email ', 'length', 'max' => 200),
            array('target', 'length', 'max' => 100),
            array('locationText', 'length', 'max' => 500),
             array('birthday', 'length', 'max' => 100),
            array('email', 'email'),
            array('phone', 'length', 'max' => 12),
            array('captcha','captcha','on'=>'register'),
            array('email', 'unique', 'className' => 'User', 'attributeName' => 'email'),
            array('image,banner', 'length', 'max' => 100),
            array('username', 'length', 'max' => 50, 'min' => 5),
            array('uploadImage', 'file', 'allowEmpty' => true, 'types' => 'jpg,bmp,jpeg,png,gif', 'maxSize' => 10000000, 'maxFiles' => 1),
            array('post_limit,id,username, create_date, update_date, type, email, image', 'safe', 'on' => 'search'),
        );
      
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products'=>array(self::HAS_MANY,'Product','user_id'),
            'addressCount'=>array(self::STAT,'Address','user_id'),
            'address' => array(self::HAS_MANY, 'Address', 'user_id'),
            
        );
    }

    public function getProductBlockedCount()
    {
        $sql = 'select count(*) from {{ban_product}} bp left join {{product}} p on bp.product_id = p.id
                where p.user_id = :userId';
        $count = Yii::app()->db->createCommand($sql)->bindValue('userId', $this->id)->queryScalar();
        if (is_numeric($count)) {
            return $count;
        }
        return 0;
    }

    public function getUserBlockedCount()
    {
        $sql = 'select count(*) from {{ban_user}} where blocked_id = :userId';
        $count = Yii::app()->db->createCommand($sql)->bindValue('userId', $this->id)->queryScalar();
        if (is_numeric($count)) {
            return $count;
        }
        return 0;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => LanguageUtil::t('ID'),
            'username' => LanguageUtil::t('Username'),
            'password' => LanguageUtil::t('Password'),
            'salt' => 'Salt',
            'create_date' => LanguageUtil::t('Create date'),
            'update_date' => LanguageUtil::t('Update date'),
            'type' => LanguageUtil::t('Type'),
            'email' => LanguageUtil::t('Email'),
            'introduction' => LanguageUtil::t('Introduction'),
            'target' => 'Tự giới thiệu',
            'birthday' => LanguageUtil::t('Birthday'),
            'locationText' => 'Địa chỉ',
            'phone' => LanguageUtil::t('Phone'),
            'post_limit'=>Yii::t('Default','Post limit'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        //$criteria->compare('password', $this->password, true);
        //$criteria->compare('salt', $this->salt, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('update_date', $this->update_date, true);

        $criteria->compare('email', $this->email, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('post_limit', $this->image, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getNameById($id)
    {
        $user = Yii::app()->db->createCommand('select username from user where id=:id')->bindValue('id', $id)->queryRow();
        if ($user != null) {
            return $user['username'];
        }
        return null;
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_NORMAL => 'Thành viên',
            self::TYPE_ADMIN => 'Quản trị viên'
        );
    }

    protected function generateSalt()
    {
        return uniqid('', true);
    }

    public function makeOptimizedPassword($password, $salt)
    {
        return md5(md5($password) . $salt);
    }

    public function beforeValidate()
    {
        $oldModel = $this->findByPk($this->id);
        if($this->birthday!=NULL&&strlen($this->birthday)>0)
        {
            $this->birthday = DateUtil::convertDate("Y-m-d",$this->birthday);
        }
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRIPPED);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        if ($this->isNewRecord) {
            $this->post_limit = self::DEFAULT_POST_LIMIT;
            $this->status = self::STATUS_ACTIVE;
            $this->salt = $this->generateSalt();
            $this->create_date = DateUtil::getCurrentDateTime();
        }

        if ($oldModel != null) {                        
            if ($this->password != $oldModel->password && trim($this->password != '')) {
                $this->password = $this->makeOptimizedPassword($this->password, $this->salt);
            }
            else {
                $this->password = $oldModel->password;
            }
        }
        else {
            $currentPassword = trim($this->password);
            if ($currentPassword != '') {
                $this->password = $this->makeOptimizedPassword($this->password, $this->salt);
            }
        }

        $this->update_date = date('Y-m-d H:i:s');
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            //No need to save image;
            //$this->image = $this->getProfileImageUrl(); 
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {
        
        return parent::afterSave();
    }

    public function afterDelete()
    {
        foreach($this->products as $product){
            $product->delete();
        }
    }

    protected function hashPassword($str)
    {
        return md5($str);
    }

    public function getGenderList()
    {
        return array(
            self::GENDER_MALE => 'Nam',
            self::GENDER_FEMALE => 'Nữ',
            self::GENDER_NOT_SPECIFY => '(Để trống)'
        );
    }

    public function getGenderText()
    {
        return isset($this->genderList[$this->gender]) ? $this->genderList[$this->gender] : null;
    }

    public function getData()
    {
        return array(
            'id' => $this->id,
            'image' => $this->getProfileImageUrl(true),
            'username' => $this->username,
            'email' => $this->email
        );
    }

    public function handleUploadImage($uploadName, $attributeName)
    {
        $uploadImage = CUploadedFile::getInstanceByName($uploadName);
        $oldImage = $this->image;

        if ($uploadImage != null) {

            $rules = new ImageUploadRules();
            if (in_array(mb_strtolower($uploadImage->extensionName), $rules->getAllowExtensions(), true) == false) {
                $this->addError('uploadImage', 'Định dạng ảnh không phù hợp');
                return false;
            }



            if ($uploadImage->size > FileUtil::convertSizeToBytes(2, 'MB')) {
                $this->addError('uploadImage', 'Kích thước ảnh không được quá 2 MB');
                return false;
            }
            $filename = 'user_image_' . $this->id . '_' . time() . '.' . $this->uploadImage->extensionName;
            $uploadImage->saveAs('images/content/profile/' . $filename);

            $imageInfo = getimagesize('images/content/profile/' . $filename);

            if ($imageInfo[0] < 180 || $imageInfo[1] < 180) {
                $this->addError('uploadImage', 'Bề ngang và bề rộng của ảnh phải lớn hơn 180px');
                @unlink('images/content/profile/' . $filename);
                return false;
            }
            $resize = ImageUtil::resize('images/content/profile/' . $filename, 300, 300);
            $this->$attributeName = $resize;
            //$rs = Yii::app()->s3->upload($resize,UserUtil::USER_IMAGE_FOLDER.'/'.$filename,Yii::app()->params['s3bucket']);                            
            @unlink('images/content/profile/' . $filename);
            if ($oldImage != null) {
                @unlink($oldImage);
            }
            //unlink($resize);
        }
    }

    public function searchProduct($category = null, $pageSize = 10, $page = 0)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $this->id);
        $criteria->compare('category_id', $category);
        $criteria->order = 'create_date desc';
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pageSize,
                'currentPage' => $page
            )
        ));
        return $productDataProvider;
    }

    public function getUserProfileLink()
    {
        return CHtml::link(
                        $this->username, $this->getUserProfileUrl(), array('title' => $this->target)
        );
    }

    public function getUserProfileUrl()
    {


        return Yii::app()->createUrl('/user/profile', array(
                    'id' => $this->id,
                    'name' =>StringUtil::makeSlug($this->username)
                        )
        );
    }

    public function getProfileImageUrl($absolute = false)
    {
     
        if ($this->image != null) {       
            if($absolute){
                return Yii::app()->params['urlManager.hostInfo'].'/'.$this->image;
            }
            return $this->image;         
        }
        else {
            if ($this->fbId != null) {
                $url = "http://graph.facebook.com/" . $this->fbId . "/picture?type=large";
                return $url;
            }
        }
        return null;
    }

    public function getBanner()
    {
        if (trim($this->banner) == '') {
            //default
            return 'images/def-banner.jpg';
        }
        else {
            return $this->banner;
        }
    }

}