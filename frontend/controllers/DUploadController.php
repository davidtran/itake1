<?php

class DUploadController extends Controller
{

    public function actions()
    {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'path' => Yii::app()->getBasePath() . "/../uploads",
                'publicPath' => Yii::app()->getBaseUrl() . "/uploads",
            ),
        );
    }

    public function actionIndex($category)
    {
        Yii::import("ext.xupload.models.XUploadForm");
        $photos = new XUploadForm;
        $product = new Product();
        $product->category_id = $category;
        if (isset($_POST['Product']))
        {
            $product->attributes = $_POST['Product'];
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                if ($product->save())
                {
                    $this->saveImages($product);
                    $transaction->commit();
                }
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                Yii::app()->handleException($e);
            }
        }
        $this->render('form', array(
            'product' => $product,
            'photos' => $photos,
            'category' => $category
            )
        );
    }

    protected function saveImages($product)
    {
        if (Yii::app()->user->hasState('images'))
        {
            $userImages = Yii::app()->user->getState('images');
            //Resolve the final path for our images
            $path = Yii::app()->getBasePath() . "/../images/content/product/{$this->id}/";
            //Create the folder and give permissions if it doesnt exists
            if (!is_dir($path))
            {
                mkdir($path);
                chmod($path, 0777);
            }

            //Now lets create the corresponding models and move the files
            foreach ($userImages as $image)
            {
                if (is_file($image["path"]))
                {
                    if (rename($image["path"], $path . $image["filename"]))
                    {
                        chmod($path . $image["filename"], 0777);
                        $img = new Image( );
                        $img->size = $image["size"];
                        $img->mime = $image["mime"];
                        $img->name = $image["name"];
                        $img->source = "/images/uploads/{$this->id}/" . $image["filename"];
                        $img->model_id = $this->id;
                        $img->model_name = 'Product';
                        if (!$img->save())
                        {
                            //Its always good to log something
                            Yii::log("Could not save Image:\n" . CVarDumper::dumpAsString(
                                            $img->getErrors()), CLogger::LEVEL_ERROR);
                            //this exception will rollback the transaction
                            throw new Exception('Could not save Image');
                        }
                    }
                }
                else
                {
                    //You can also throw an execption here to rollback the transaction
                    Yii::log($image["path"] . " is not a file", CLogger::LEVEL_WARNING);
                }
            }
            //Clear the user's session
            Yii::app()->user->setState('images', null);
        }
    }

}