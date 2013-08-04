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

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public $facebookPost;
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
            array('title, description,address_id,price, city,category_id', 'required'),
            array('address_id, view,price,category_id,city', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('description', 'length', 'max' => 500),         
            array('phone,lat,lon,locationText', 'safe'),
            array('address_id', 'exist', 'className' => 'Address', 'attributeName' => 'id'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, price, user_id, image, create_date', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {

        return array(
            'id' => 'Mã',
            'title' => 'Tên sản phẩm',
            'description' => 'Mô tả',
            'price' => 'Giá',
            'user_id' => 'Người dùng',
            'image' => 'Hình',
            'phone' => 'Điện thoại liên hệ',
            'create_date' => 'Ngày tạo',
            'locationText' => 'Địa chỉ',
            'city' => 'Thành phố',
            'category_id' => 'Danh mục',
            'address_id' => 'Địa chỉ bán hàng'
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

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->create_date = date('Y-m-d H:i:s');
            $this->view = 0;
        }
        if ($this->address != null)
        {
            $this->locationText = $this->address->address;
            $this->phone = $this->address->phone;
            $this->city = $this->address->city;
            $this->lat = $this->address->lat;
            $this->lon = $this->address->lon;
        }
        $this->price = intval(StringUtil::removeSpecialCharacter($this->price));
        return parent::beforeValidate();
    }
    
    public function beforeSave()
    {
        $this->title = filter_var($this->title,FILTER_SANITIZE_SPECIAL_CHARS);
        $this->description = filter_var($this->description,FILTER_SANITIZE_SPECIAL_CHARS);                
        return parent::beforeSave();
    }

    public function saveImageFromForm()
    {
        $file = CUploadedFile::getInstance($this, 'image');
        if ($file != null)
        {
            $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter($this->title)) .
                    '_' .
                    rand(0, 999) .
                    '.' .
                    'png';
            $filename = 'images/content/' . $filename;
            if ($file->saveAs($filename, true))
            {
                //$this->drawImage($filename);
                $this->image = $filename;
                return true;
            }
        }
        return false;
    }

    public function saveImage()
    {
        if (isset($_REQUEST['image']))
        {
            $binary = base64_decode($_REQUEST['image']);
            $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter($this->title)) .
                    '_' .
                    rand(0, 999) .
                    '.' .
                    'png';
            $filename = 'images/content/' . $filename;
            $processed = 'images/content/processed/' . $filename;
            $f = fopen($filename, 'wb');

            if ($f !== false)
            {
                fwrite($f, $binary);
                fclose($f);
                if (ProductImageUtil::drawImage($this, $filename, $processed))
                {
                    $this->image = $filename;
                    $this->processed_image = $processed;
                    return true;
                }
                else
                {
                    $this->addError('image', 'Draw image failed');
                }
            }
        }
        else
        {
            $this->addError('image', 'Image is not found');
        }
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

    public function getAbsoluteDetailUrl()
    {
        return Yii::app()->controller->createAbsoluteUrl('/product/details', array('id' => $this->id, 'title' => $this->title));
    }

    public function renderHtml($prefix = "")
    {
        //like, comment
        $html = Yii::app()->controller->renderPartial('/site/_productItem', array(
            'product' => $this,
            'prefix' => $prefix,
                ), true, false);
        return $html;
    }

    public function renderImageLink()
    {
        return Yii::app()->controller->renderPartial('/site/_productImage', array(
                    'product' => $this
                        ), true, false);
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
        $dateFormatter = new CDateFormatter(Yii::app()->getLocale('vi'));
        if ($elapseTime < $day || $elapseTime > $year)
        {
            return DateUtil::elapseTime($this->create_date) . ' trước';
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