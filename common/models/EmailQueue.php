<?php

/**
 * This is the model class for table "{{email_queue}}".
 *
 * The followings are the available columns in table '{{email_queue}}':
 * @property integer $id
 * @property string $from_email
 * @property string $to_email
 * @property string $subject
 * @property string $params
 * @property integer $max_attempts
 * @property integer $attempts
 * @property integer $success
 * @property string $create_date
 * @property string $last_attempt
 * @property string $send_date
 * @property string $unique_hash
 */
class EmailQueue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailQueue the static model class
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
		return '{{email_queue}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_email, to_email, subject, params, unique_hash', 'required'),
			array('max_attempts, attempts, success', 'numerical', 'integerOnly'=>true),
			array('from_email, to_email', 'length', 'max'=>128),
			array('subject', 'length', 'max'=>255),
			array('unique_hash', 'length', 'max'=>32),
			array('create_date, last_attempt, send_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_email, to_email, subject, params, max_attempts, attempts, success, create_date, last_attempt, send_date, unique_hash', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'from_email' => 'From Email',
			'to_email' => 'To Email',
			'subject' => 'Subject',
			'params' => 'Params',
			'max_attempts' => 'Max Attempts',
			'attempts' => 'Attempts',
			'success' => 'Success',
			'create_date' => 'Create Date',
			'last_attempt' => 'Last Attempt',
			'send_date' => 'Send Date',
			'unique_hash' => 'Unique Hash',
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
		$criteria->compare('from_email',$this->from_email,true);
		$criteria->compare('to_email',$this->to_email,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('max_attempts',$this->max_attempts);
		$criteria->compare('attempts',$this->attempts);
		$criteria->compare('success',$this->success);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('last_attempt',$this->last_attempt,true);
		$criteria->compare('send_date',$this->send_date,true);
		$criteria->compare('unique_hash',$this->unique_hash,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}