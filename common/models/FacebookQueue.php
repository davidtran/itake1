<?php

/**
 * This is the model class for table "{{facebook_queue}}".
 *
 * The followings are the available columns in table '{{facebook_queue}}':
 * @property integer $id
 * @property string $command
 * @property string $params
 * @property string $create_date
 * @property integer $success
 * @property integer $status
 * @property string $success_date
 * @property integer $type
 */
class FacebookQueue extends CActiveRecord
{
    const STATUS_FRESH = 0;
    CONST STATUS_WAIT = 1;
    const STATUS_REFRESHED = 2;
    const STATUS_STOPPED = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FacebookQueue the static model class
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
		return '{{facebook_queue}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('command, params, create_date, success, status, type', 'required'),
			array('success, status, user_id', 'numerical', 'integerOnly'=>true),
			array('command', 'length', 'max'=>100),
            array('hash','length','max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, command, params, create_date, success, status, success_date, type', 'safe', 'on'=>'search'),
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
			'command' => 'Command',
			'params' => 'Params',
			'create_date' => 'Create Date',
			'success' => 'Success',
			'status' => 'Attemps',
			'success_date' => 'Success Date',
			'type' => 'Type',
			
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
		$criteria->compare('command',$this->command,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('success',$this->success);
		$criteria->compare('status',$this->status);
		$criteria->compare('success_date',$this->success_date,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->create_date = date('Y-m-d H:i:s');
            $this->status = self::STATUS_FRESH;
        }
        return parent::beforeValidate();
    }
}