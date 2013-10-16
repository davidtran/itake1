<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','delete','update'),
				'users'=>  UserRoleConstant::getAdminUserList()
			),			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        if(Yii::app()->user->checkAccess('viewProduct')){
            $this->render('view',array(
                'model'=>$this->loadModel($id),
            ));
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        return;
		$model=new Product;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{        
        if(Yii::app()->user->checkAccess('updateProduct')){
            $model=$this->loadModel($id);
            if(isset($_POST['Product']))
            {
                $model->attributes=$_POST['Product'];
                if($model->save()){             
                    $this->redirect(array('update','id'=>$model->id));
                }

            }

            $this->render('update',array(
                'model'=>$model,
            ));
        }
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if(Yii::app()->user->checkAccess('deleteProduct')){
            
            $product = $this->loadModel($id);           
            $product->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $this->layout='//layouts/column1';
        if(Yii::app()->user->checkAccess('viewProduct')){
            $model=new Product('search');
            $model->unsetAttributes();  // clear any default values
            

            $this->render('index',array(
                'model'=>$model,
            ));
        }
		
	}
    
    public function searchProduct($model){
        if(isset($_GET['Product']))
                $model->attributes=$_GET['Product'];
        $criteria = new CDbCriteria;

        $criteria->compare('id', $model->id);
        $criteria->compare('title', $model->title, true);
        $criteria->compare('category_id',$model->category_id,true);
        $criteria->compare('description', $model->description, true);
        $criteria->compare('price', $model->price);
        $criteria->compare('user_id', $model->user_id);        
        $criteria->compare('create_date', $model->create_date, true);
        $criteria->compare('status', $model->create_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
