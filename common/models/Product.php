<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $price
 * @property integer $user_id
 * @property string $image
 * @property string $processed_image
 * @property string $create_date
 * @property string $location
 */
class Product extends CActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED = 2;
    const STATUS_SOLD = 3;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public $uploadToFacebook = true;
    public $priceDisplay;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        $this->view = 0;
        return parent::init();
    }        

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, description,address_id,category_id', 'required'),
            array('no_price,uploadToFacebook,status,country,address_id, view,price,category_id,city', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 200),
            array('price','checkPrice'),
            array('description', 'length', 'max' => 4000),         
            array('phone,lat,lon,locationText', 'safe'),
            array('address_id', 'exist', 'className' => 'Address', 'attributeName' => 'id'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, price, user_id, image, create_date', 'safe', 'on' => 'search'),
        );
    }
    
    public function checkPrice($attr,$value){
        if($this->no_price == 0 && empty($this->price)){
            $this->addError('price', 'Price can not be zeno.');
        }
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
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
            'countryModel' => array(self::BELONGS_TO, 'Country', 'country'),
            'cityModel' => array(self::BELONGS_TO, 'City', 'city'),
            
            'firstImage'=>array(self::HAS_ONE,'ProductImage','product_id','order'=>'number'),
            'images'=>array(self::HAS_MANY,'ProductImage','product_id','order'=>'number'),  
            'imageCount'=>array(self::STAT,'ProductImage','product_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'product_id', 'condition'=>'comments.status='.Comment::STATUS_APPROVED, 'order'=>'comments.create_date DESC','limit'=>5),
            'rootComments' => array(self::HAS_MANY, 'Comment', 'product_id', 'condition'=>'rootComments.status='.Comment::STATUS_APPROVED.' and rootComments.parent_id is null', 'order'=>'rootComments.create_date DESC','limit'=>5),
            'commentCount' => array(self::STAT, 'Comment', 'product_id', 'condition'=>'status='.Comment::STATUS_APPROVED.' and parent_id is null'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {

        return array(
            'id' => Yii::t('Default','ID'),
            'title' => Yii::t('Default','Title'),
            'description' => Yii::t('Default','Description'),
            'price' => Yii::t('Default','Price'),
            'user_id' => Yii::t('Default','User'),
            'image' => Yii::t('Default','Image'),
            'phone' => Yii::t('Default','Phone'),
            'create_date' => Yii::t('Default','Create date'),
            'locationText' => Yii::t('Default','Street'),
            'city' => Yii::t('Default','City'),
            'category_id' => Yii::t('Default','Category'),
            'address_id' => Yii::t('Default','Address'),
            'uploadToFacebook'=>  Yii::t('Default','Post to your Facebook profile'),
            'no_price'=>Yii::t('Default','Contact price'),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('create_date', $this->create_date, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getStatusList(){
        return array(
            self::STATUS_ACTIVE=>'Active',
            self::STATUS_INACTIVE=>'Inactive',
            self::STATUS_DELETED=>'Deleted',
            self::STATUS_SOLD=>'Sold'
        );
    }
    public function getStatusText(){
        return isset($this->statusList[$this->status]) ? $this->statusList[$this->status]:null; 
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->create_date = date('Y-m-d H:i:s');
            $this->view = 0;
           // $this->status = Product::STATUS_INACTIVE;
        }
        if(mb_strlen($this->title,'utf-8')> 50){
            $this->title = mb_substr($this->title,0,50,'utf-8');
        }
        $this->price = intval(StringUtil::removeSpecialCharacter($this->price));
        return parent::beforeValidate();
    }
    
    public function beforeSave()
    {
        if($this->isNewRecord){
            $this->country = Yii::app()->country->getId();
            $this->view = 1;
            $this->status = self::STATUS_ACTIVE;
        }
        if ($this->address != null)
        {                        
            $this->locationText = $this->address->address;
            $this->phone = $this->address->phone;
            $this->city = $this->address->city;
            $this->lat = $this->address->lat;
            $this->lon = $this->address->lon;
        }
        $this->title = strip_tags($this->title);
        $description = strip_tags($this->description,'<br><p>');
        $this->description = $description;
        
        
        return parent::beforeSave();
    }     
    
    public function afterSave()
    {        
        try{
            $importer = new ProductModelSolrImporter();
            $importer->addProduct($this);
            $importer->importProduct();
        }
        catch(Exception $e){
            $this->addError('id', 'Solr error');
        }
        return parent::afterSave();
    }
    
    public function beforeDelete()
    {
        try{
            $importer = new ProductModelSolrImporter();
            $importer->deleteProduct($this);
        }
        catch(Exception $e){
            $this->addError('id', 'Solr error');
            return false;
        }
        return parent::beforeDelete();
    }
  
    public function getDistance($lat, $lon)
    {
        return round(DistanceUtil::calculate($this->lat, $this->lon, $lat, $lon), 3);
    }

    public function getDetailUrl($absolute = false)
    {
        if ($absolute)
        {
            return Yii::app()->controller->createAbsoluteUrl(
                            '/product/details', array(
                        'id' => $this->id,
                        'title' => StringUtil::makeSlug($this->title)
                            )
            );
        }
        else
        {
            return Yii::app()->controller->createUrl(
                            '/product/details', array(
                        'id' => $this->id,
                        'title' => StringUtil::makeSlug($this->title)
                            )
            );
        }
    }

    public function renderHtml($prefix = "",$showControl = false)
    {
        //like, comment
        $html = Yii::app()->controller->renderPartial('/site/_productItem', array(
            'product' => $this,
            'prefix' => $prefix,
            'showControl'=>$showControl
                ), true, false);
        return $html;
    }

    public function renderImageLink()
    {
        return Yii::app()->controller->renderPartial('/site/_productImage', array(
                    'product' => $this
                        ), true, false);
    }
    
    public function getFirstImage(){
        if($this->firstImage !=null){
            return $this->firstImage->thumbnail;
        }
    }

    public function searchRelateProduct($pageSize = 5, $page = 0)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('category_id', $this->category_id);
        $criteria->order = 'create_date desc';
        return new CActiveDataProvider('Product', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pageSize,
                'currentPage' => $page
            )
        ));
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
            return DateUtil::elapseTime($this->create_date) . ' '.Yii::t('Default','ago',null).'';
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
    public function addComment($comment)
    {
        // if(Yii::app()->params['commentNeedApproval'])
        //     $comment->status=Comment::STATUS_PENDING;
        // else
            $comment->status=Comment::STATUS_APPROVED;
        $comment->product_id=(int)$this->id;
        return $comment->save();
    }

}