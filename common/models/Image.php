<?php

/**
 * This is the model class for table "{{image}}".
 *
 * The followings are the available columns in table '{{image}}':
 * @property integer $id
 * @property string $size
 * @property string $mime
 * @property string $source
 * @property integer $model_id
 * @property string $model_name
 * @property string $create_date
 */
class Image extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
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
		return '{{image}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size, mime, source, model_id, model_name, create_date', 'required'),
			array('model_id', 'numerical', 'integerOnly'=>true),
			array('size, mime', 'length', 'max'=>20),
			array('source', 'length', 'max'=>100),
			array('model_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, size, mime, source, model_id, model_name, create_date', 'safe', 'on'=>'search'),
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
			'size' => 'Size',
			'mime' => 'Mime',
			'source' => 'Source',
			'model_id' => 'Model',
			'model_name' => 'Model Name',
			'create_date' => 'Create Date',
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
		$criteria->compare('size',$this->size,true);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}