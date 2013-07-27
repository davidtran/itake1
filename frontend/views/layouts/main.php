<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        
       <!--  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'/>        
        <link href='http://fonts.googleapis.com/css?family=Roboto:700,700italic,900,500italic,500,400,400italic' rel='stylesheet' type='text/css'/> -->
                
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
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-combined.no-icons.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
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
        <div id="footer">
            <div class="row-fluid">
                <div class="span4">
                    
                </div>
                <div class="span4">
                    <div id="viewTypeDisplay">
<!--                        <label><i class="icon-sort-by-attributes"></i> Sắp xếp</label>-->
<!--                        <select>
                            <option>Thời gian</option>
                            <option>Xu hướng</option>
                            <option>Khoảng cách</option>
                        </select>-->                        
                    </div>
                </div>
                <div class="span4">
                    <div class="navigation">
                        <ul>                                                        
<!--                            <li class="first"><a>Điều khoản</a></li>
                            <li><a>Phản hồi</a></li>
                            <li><a>Liên hệ</a></li>-->
                            <li class="first"><a>© 2013 ITAKE.ME</a></li>
                        </ul>
                    </div>                   
                </div>
            </div>
        </div>
    </body>
</html>
