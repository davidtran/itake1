<?php

/**
 * This is the model class for table "{{user_email}}".
 *
 * The followings are the available columns in table '{{user_email}}':
 * @property integer $id
 * @property integer $email
 * @property integer $code
 * @property integer $is_verified
 * @property string $update_date
 */
class UserEmail extends CActiveRecord {

    const IS_VERIFIED_YES = 1;
    const IS_VERIFIED_NO = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserEmail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_email}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' email, code, is_verified', 'required'),
            array('is_verified', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,email, code, is_verified, update_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'code' => 'Code',
            'is_verified' => 'Is Verified',
            'update_date' => 'Update Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);   
        $criteria->compare('email', $this->email);
        $criteria->compare('code', $this->code);
        $criteria->compare('is_verified', $this->is_verified);
        $criteria->compare('update_date', $this->update_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function beforeValidate() {
        if($this->isNewRecord){
            $this->is_verified = self::IS_VERIFIED_NO;
        }
        return parent::beforeValidate();
    }

    public static function createVerifyUrl($email,$code) {
        return Yii::app()->createAbsoluteUrl('/user/verifyEmail', array(
                    'email' => $email,
                    'code' => $code
        ));
    }

    public static function generateVerifyCode($email) {
        $code = md5(StringUtil::generateRandomString(25).$email);       
        $sql = 'select count(*) from {{user_email}} where email=:email';
        $sql = 'insert into {{user_email}}(email,code,is_verified) value(:email,:code,0) on duplicate key 
                update code=:code';
        Yii::app()->db->createCommand($sql)->query(array(
            'email'=>$email,
            'code'=>$code,            
        ));
        return $code;        
    }

    public static function sendVerifyEmail($user) {
        $code = self::generateVerifyCode($user->email);
        return EmailUtil::queue(
            Yii::app()->params['email.adminEmail'], 
            $user->email, 
            'verifyEmail', 
            array(
                'username' => $user->username,
                'code' => $code,
                'verifyUrl' => self::createVerifyUrl($user->email,$code),
            ), 
            'Xác thực email của bạn tại ListenToMe.vn',
            false);
    }

    public static function isEmailVerified($email) {
        $sql = 'select is_verified from {{user_email}} where email like :email';
        $isVerified = Yii::app()->db->createCommand($sql)->bindValues(array(
                    'email' => $email
                ))->queryScalar();
        if ($isVerified === self::IS_VERIFIED_YES) {
            return true;
        }
        return false;
    }

    public static function verifyEmailAndCode($email, $code) {
        $sql = 'select is_verified from {{user_email}} where email like :email and code=:code';
        $isVerified = Yii::app()->db->createCommand($sql)->bindValues(array(
                    'email' => $email,
                    'code' => $code,                   
                ))->queryScalar();
        if ($isVerified !== false) {
            Yii::app()->db->createCommand()->update('{{user_email}}', array(
                        'is_verified' => self::IS_VERIFIED_YES
                    ), 'email=:email and code=:code', array(
                'email' => $email,
                'code' => $code,
            ));
            return true;
        }
        return false;
    }        

}