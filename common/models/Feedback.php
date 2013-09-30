<?php

/**
 * This is the model class for table "{{feedback}}".
 *
 * The followings are the available columns in table '{{feedback}}':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $url
 * @property string $message
 * @property string $create_date
 */
class Feedback extends CActiveRecord
{
    public $captcha;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{feedback}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, message, create_date', 'required'),
			array('id,user_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
            array('email','email'),
			array('email, url', 'length', 'max'=>100),
            array('captcha','captcha'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, email, url, message, create_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{

		return array(
			'id' => LanguageUtil::t('ID'),
			'username' => LanguageUtil::t('Username'),
			'email' => LanguageUtil::t('Email'),
			'url' => 'Url',
			'message' => LanguageUtil::t('Feedback content'),
			'create_date' => LanguageUtil::t('Create date'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->create_date = date('Y-m-d H:i:s');            
        }
        $this->message = filter_var($this->message,FILTER_SANITIZE_ENCODED);
        $this->url = filter_var($this->url,FILTER_SANITIZE_URL);
        $this->username = filter_var($this->username,FILTER_SANITIZE_STRIPPED);
        $this->email = filter_var($this->email,FILTER_SANITIZE_EMAIL);        
        return parent::beforeValidate();
    }
}