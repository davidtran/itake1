<?php

/**
 * This is the model class for table "{{rating}}".
 *
 */
class Rating extends CActiveRecord
{
	const MAX_SCORE = 5;
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
		return '{{rating}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id,user_id,score', 'required'),
			array('product_id,user_id,score', 'numerical', 'integerOnly'=>true),			
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
			'user'=>array(self::BELONGS_TO,'User','user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		
		);
	}
	
	public static function getAverageScoreForProduct($productId) {
		return Yii::app()->db
				->createCommand('select avg(score) from {{rating}} where product_id=:product_id')
				->queryScalar(array(
					'product_id'=>$productId
				));
	}	

	public static function isUserRatedProduct($userId,$productId) {
		$count = Yii::app()
			->db
			->createCommand('select count(*) from {{rating}} where user_id =:user_id and product_id = :product_id')
			->queryScalar(array(
				'user_id'=>$userId,
				'product_id'=>$productId
			));			
		if(is_numeric($count) && $count > 0){
			return true;
		}			
		return false;
	}

	public static function getTotalUserCountForProduct($productId){
		$count = Yii::app()
			->db
			->createCommand('select count(*) from {{rating}} where product_id = :product_id')
			->queryScalar(array(				
				'product_id'=>$productId
			));			
		if(is_numeric($count) && $count > 0){
			return $count;
		}			
		return false;	
	}


	public static function addRatingScore($userId,$productId,$score) {	
		$insertSql = 'insert into {{rating}}(user_id,product_id,score) values(:user_id,:product_id,:score) on duplicate key update score=:score';
		return Yii::app()->db->createCommand($insertSql)->query(array(
			'user_id' => $userId,
			'product_id' => $productId,
			'score' => $score
		));		
	}
}