<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductUtil
{

    const PAGE_SIZE = 20;

    public static function searchProductByCategory($keyword = null, $category = null, $city = 0, $page = 0)
    {
        //get product list and sort by time, then sort by 
        $keyword = strtolower($keyword);
        assert('is_numeric($page)');


        $criteria = new CDbCriteria();
        $criteria->compare('lower(title)', $keyword, true, 'or');
        $criteria->compare('lower(description)', $keyword, true, 'or');
        $criteria->compare('category_id', $category);
        if ($city == CityUtil::ALL_ID || $city == null)
        {
            $cityList = CityUtil::getCityListData(true);
            $inCity = array();
            foreach ($cityList as $cityId => $c)
            {
                $inCity[] = $cityId;
            }
            $criteria->addInCondition('city', $inCity);
        }
        else
        {
            $criteria->compare('city', $city);
        }
        $criteria->order = 'create_date desc';

        return new CActiveDataProvider('Product', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
                'currentPage' => $page
            )
        ));
    }

    public static function searchProductByLocation($latitude, $longitude, $keyword = null, $category = null, $city = null, $page = 0)
    {
        //get product list and sort by time, then sort by 
        assert('is_numeric($page)');
        $keyword = strtolower($keyword);
        $criteria = new CDbCriteria();
        $criteria->select = "*, getdistance($latitude,$longitude,lat,lon) distance, date_format(create_date,'%Y-%m-%d') dateMonth";
        $criteria->compare('lower(title)', $keyword, true, 'or');
        $criteria->compare('lower(description)', $keyword, true, 'or');
        $criteria->compare('category_id', $category);
        if ($city == CityUtil::ALL_ID || $city == null)
        {
            $cityList = CityUtil::getCityListData(true);
            $inCity = array();
            foreach ($cityList as $cityId => $c)
            {
                $inCity[] = $cityId;
            }
            $criteria->addInCondition('city', $inCity);
        }
        else
        {
            $criteria->compare('city', $city);
        }

        $criteria->order = 'dateMonth desc, distance desc';
        if($longitude!=null && $latitude!=null){
            $criteria->order = 'dateMonth desc, distance desc';
        }else{
            $criteria->order = 'create_date desc';
        }
        return new CActiveDataProvider('Product', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
                'currentPage' => $page
            )
        ));
    }

    public function searchFacebookFriendProduct($page = 0)
    {
        if (Yii::app()->user->isGuest == false)
        {
            try
            {
                $friendList = FacebookUtil::getFacebookFriendInApp();
                $friendList[] = Yii::app()->user->getId();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('user_id', $friendList);
                $criteria->order = 'create_date desc';
                $dataProvider = new CActiveDataProvider('Product', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                        'currentPage' => $page
                    )
                ));
                return $dataProvider;
            }
            catch (FacebookApiException $e)
            {
                throw new CException('User is not login by Facebook');
            }
        }
        throw new CException('User is not login');
    }

}

?>
