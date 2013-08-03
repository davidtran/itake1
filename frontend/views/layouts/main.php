<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        
       <!--  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'/>        
        <link href='http://fonts.googleapis.com/css?family=Roboto:700,700italic,900,500italic,500,400,400italic' rel='stylesheet' type='text/css'/> -->
                <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
        
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-1.8.2.min.js"></script>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php
        $baseUrl = Yii::app()->baseUrl;
        Yii::app()->clientScript->registerScript('site info', "var BASE_URL = '$baseUrl'", CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/imagesloaded.pkgd.min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.imageloader.js', CClientScript::POS_HEAD);        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.isotope.min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/modal2/css/bootstrap-modal.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modal2/js/bootstrap-modal.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modal2/js/bootstrap-modalmanager.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCoreScript('jqueryui');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.scrollUp.min.js', CClientScript::POS_HEAD);        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.slimscroll.min.js', CClientScript::POS_HEAD);        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.history.js', CClientScript::POS_HEAD);       
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/common.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/feedback.js', CClientScript::POS_HEAD);
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-combined.no-icons.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/itake.css" />
        <!--[if IE 7]>
          <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->
        <?php
        Yii::app()->controller->widget('ext.seo.widgets.SeoHead', array(
            'defaultDescription' => 'iTake.me - Take the favorite. Chợ mua bán những sản phẩm nhanh trên smartphone',
            'defaultKeywords' => 'rao vặt trên smartphone, chợ trực tuyến, ô tô, xe máy, nhà đất, căn hộ, điện thoại, thiết bị điện tử'
        ));
        ?>        
    </head>

    <body class="ostyle">                        
        <div class="page-container">            
            <div class="container-fluid" >
                
                <?php echo $content ?>
                
            </div>  
        </div>
        <div id="fb-root"></div>
        <script>
          (function() {
            var e = document.createElement('script');
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
          }());
        </script>         
        <script type="text/javascript">
          (function() {
           var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
           po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
         })();
        </script>
         <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5165a11f04e5f961">
                addthis.toolbox('.addthis_toolbox');
        </script>
          <div class="row-fluid">
                <hr class="sep_item"/>
            </div>
        <div id="footer">          
            <div class="row-fluid">                               
                <div class="span12">
                    <div class="navigation">
                        <ul>                                                        
                            <li class="first"><a><b style="color:#194675"><i class="icon-desktop"></i>   PHIÊN BẢN THỬ NGHIỆM</a></b></li>
                            <li class="first" ><a href="<?php echo Yii::app()->createUrl('site/introduction') ?>">GIỚI THIỆU</a></li>
                            <li ><a href="<?php echo Yii::app()->createUrl('site/terms') ?>">ĐIỀU KHOẢN</a></li>       
                            <li ><a>PHẢN HỒI</a></li>                                                     
                            <li><a href="<?php echo Yii::app()->createUrl('site/index') ?>">© <?php echo date('Y') ?> ITAKE.ME</a></li>
                        </ul>
                    </div>                   
                </div>
            </div>
        </div>
    </body>
</html>
