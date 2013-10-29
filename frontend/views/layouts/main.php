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
        
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-1.8.2.min.js"></script>
        <?php
        Yii::app()->controller->widget('frontend.extensions.seo.widgets.SeoHead', array(
            'defaultDescription' => LanguageUtil::t("ITAKE.ME ! It's easy and so simple to internet marketing on your products, classified ads on Fashion, Mobile and Tablet, Desktop and Latop, Camera and Electrical Devices, Handmade and Art, Services, Real Estate, Car and Motobike, Others"),
            'defaultKeywords' => 'rao vặt trên smartphone, chợ trực tuyến, ô tô, xe máy, nhà đất, căn hộ, điện thoại, thiết bị điện tử'
        ));
        ?>        
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php
        $baseUrl = Yii::app()->baseUrl;
        $absoluteUrl = Yii::app()->getBaseUrl(true);
        Yii::app()->clientScript->registerScript('site info', "
            var BASE_URL = '$baseUrl';
            var ABSOLUTE_URL = '$absoluteUrl';", CClientScript::POS_HEAD);
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
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/flexslider/flexslider.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/flexslider/jquery.flexslider-min.js', CClientScript::POS_HEAD);       
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/common.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/feedback.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/magnific/magnific-popup.css');
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/magnific/jquery.magnific-popup.min.js', CClientScript::POS_HEAD);
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-combined.no-icons.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/itakestyle.css" />
        <!--[if IE 7]>
          <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->
        <!-- HmIxT9hT1VdUAtjoRIXeBL1DE_c -->
        <meta name="alexaVerifyID" content="HmIxT9hT1VdUAtjoRIXeBL1DE_c" />
        <meta name="keywords" 
        content="itake,classified ad, rao vat, rao vat mobile, HmIxT9hT1VdUAtjoRIXeBL1DE_c" />
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
             var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-42949373-1']);
            _gaq.push(['_trackPageview']);
          (function() {
           var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
           po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
         })();
        </script>
        
        <div id="footer">  
            <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

              ga('create', 'UA-42949373-1', 'itake.me');
              ga('send', 'pageview');

            </script>        
            <div class="row-fluid">                               
                <div class="span12">
                    <div class="navigation" style="text-transform:uppercase;">
                        <ul>                                                        
                            <li class="first"><a href="<?php echo Yii::app()->createUrl('site/') ?>"><b style="color:#194675"><i class="icon-desktop"></i>   <?php LanguageUtil::echoT('Beta version') ?> </a></b></li>                                                        
                            <li class="first"><a href="<?php echo Yii::app()->createUrl('site/viLang') ?>">
                            <img style="margin-top:-6px;" src="<?php echo Yii::app()->baseUrl.'/images/vi_flag.png'?>"></a></li>    
                             <li style="margin-left:-6px;" class="first"><a href="<?php echo Yii::app()->createUrl('site/enLang') ?>">
                            <img style="margin-top:-6px;" src="<?php echo Yii::app()->baseUrl.'/images/en_flag.png'?>"></a></li>                                                      
                            <li class="first" ><a href="<?php echo Yii::app()->createUrl('site/landing') ?>"><?php LanguageUtil::echoT('Introduction') ?> </a></li>
                            <li ><a href="<?php echo Yii::app()->createUrl('site/terms') ?>"><?php LanguageUtil::echoT('Terms') ?></a></li>                                                                           
                            <li><a href="<?php echo Yii::app()->createUrl('welcome') ?>">© <?php echo date('Y') ?> ITAKE.ME</a></li>
                        </ul>
                    </div>                   
                </div>
            </div>
            <div class="main-notification" style="display: none;">
                <p>
                    <i class="icon-bell-alt icon-2x"></i>
                    <br>
                    <span></span>
                </p>
            </div>
        </div>
    </body>
</html>
