<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property string $content
 * @property string $create_date
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $status
 * @property integer $parent_id
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	const STATUS_PENDING=1;
	const STATUS_APPROVED=2;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, create_date, user_id, product_id, status', 'required'),
			array('user_id, product_id, status, parent_id', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>5000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, create_date, user_id, product_id, status', 'safe', 'on'=>'search'),
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
			 'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			 // 'parent' => array(self::BELONGS_TO, 'Comment', 'parent_id'),
			 'parentModel' => array(self::HAS_MANY, 'Comment', 'parent_id','order'=>'parentModel.create_date DESC','limit'=>5),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Comment',
			'create_date' => 'Create Date',
			'user_id' => 'User',
			'product_id' => 'Product',
			'status' => 'Status',
			'parent_id' => 'Parent',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function beforeValidate(){
		if ($this->isNewRecord)
        {
            $this->create_date = date('Y-m-d H:i:s');
           $this->user_id = (int)Yii::app()->user->id;
        }
        return parent::beforeValidate();
	}

	public function displayDateTime()
    {
        $day = 3600 * 24;
        $threeDays = $day * 3;
        $elapseTime = time() - strtotime($this->create_date);
        $week = $day * 7;
        $year = $day * 365;
        $dateFormatter = new CDateFormatter(Yii::app()->getLocale(Yii::app()->language));
        if ($elapseTime < $day || $elapseTime > $year)
        {
        	$timeString = DateUtil::elapseTime($this->create_date);
        	if (strlen($timeString)==0) {
        		$timeString = "1 ".Yii::t('Default','second',null);
        	}
            return $timeString. ' '.Yii::t('Default','ago',null).'';
        }
        else if ($elapseTime < $day * 2)
        {
            return Yii::t('Default', 'Yesterday at {time}', array(
                        '{time}' => $dateFormatter->format('HH:mm', strtotime($this->create_date)
                        )
            ));
        }
        else
        {


            $pattern = null;
            if ($elapseTime < $week)
            {
                $pattern = 'EEEE';
            }
            else
            {
                $pattern = 'd, MMMM';
            }

            return Yii::t('Default', '{date} at {time}', array(
                        '{date}' => $dateFormatter->format($pattern, strtotime($this->create_date)),
                        '{time}' => $dateFormatter->format('HH:mm', strtotime($this->create_date))
            ));
        }
    }
}