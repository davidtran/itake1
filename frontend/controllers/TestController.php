<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author David Tran
 */
class TestController extends Controller
{
    //put your code here
    public function actionCreateAdmin()
    {
        $user = new User();
        $user->username = 'David Tran';
        $user->email = 'nam.trankhanh.vn@gmail.com';
        $user->password = '123456';
        $user->fbId = '100003724941703';        
        $user->save();
    }
    public function actionLang()
    {                  
        echo Yii::t('Default','Search',null);
    }
    
    protected function getSampleProduct(){
        //draw an image 
        $product = new Product();
        $product->title = 'Cầu Vĩnh Tuy lại xuất hiện lún nứt kéo dài';
        $product->price = 7000000;
        $product->phone = '01217703647';
        $product->description = 'Đến môt ngày anh ngồi tập chát
Anh lại thấy tiếng ai đang buzz bên
chợt nhớ hôm qua vừa mới quen một cô gái xinh xinh
Cùng tiếng nói ấm áp đôi môi hiền ngoan 
Ai cũng ngĩ rằng là một trò vui 
Nhưng trong trò vui chứa chan bao lời yêu thương...bao ngọt ngào 
Từng lời đắm say in đắm mãi trong tim từng phút giây';
        $product->image = 'images/content/test.jpeg';
        $product->processed_image = 'images/content/test_processed.jpeg';
        $product->address_id = 1;
        $product->user_id = 8;
        return $product;
    }
    public function actionDrawImage(){
        $product = $this->getSampleProduct();
        ProductImageUtil::drawImage($product,Yii::app()->basePath.'/www/images/content/Khung-nh-p_600.jpg', Yii::app()->basePath.'/www/images/content/AAAAAAAAAAAAAAA.jpg');        
    }    
    
    public function actionDrawSmallImage(){
        $product = $this->getSampleProduct();
        ProductImageUtil::drawImage($product,Yii::getPathOfAlias('root').'/lazada.jpg', Yii::getPathOfAlias('root').'/lazada1.jpg');        
    }
    public function actionShareProduct($id){
        $product = Product::model()->findByPk($id);        
        if($product!=null){
            FacebookUtil::getInstance()->shareProductToFacebook($product);      
        }
        
    }
    public function actionLimitText($text){
        echo StringUtil::smartLimit($text);
    }
    
    public function actionImportProduct(){
        $productList = Product::model()->findAll();
        $importer = new ProductSearchImporter();
        $importer->importProduct($productList);
    }
    
    public function actionSearch($keyword){
    
        $solrSearch = new SolrSearchAdapter();        
        $solrSearch->keyword = $keyword;
        $result = $solrSearch->search();
        foreach($result->productList as $product){
            echo $product->title.'<br/>';
        }
      
        
    }
    
    public function actionViewCount(){
        $filename = '../solr/solr/data/index/_external_view_count.txt';
        $viewCountListSql = 'select id,view from {{product}}';
        $viewCountList = Yii::app()->db->createCommand($viewCountListSql)->queryAll();
        $f = fopen($filename,'w');
        $lines = '';
        foreach($viewCountList as $row){
            $lines.=$row['id'].'='.$row['view'].PHP_EOL;
        }
        fwrite($f, $lines);
        fclose($f);
    }
    
    public function actionUpdateCategory(){
        Yii::app()->db->createCommand("INSERT INTO  `itake`.`mp_category` (
`id` ,
`name` ,
`description` ,
`icon`
)
VALUES (
NULL ,  'Hàng thủ công mỹ nghệ',  '',  'icon-gift'
);")->query();
    }
    
    public function actionHtml(){
        $script = <<<HERE
<DIV STYLE="background-image: url(javascript:alert('XSS'))">                
HERE;
    
        echo filter_var($script,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    public function actionFilter(){
        $html = '<p>dasdasd</p><br/><p>adsad</p>ada#@$#%&^^<?php ?>addas&(Q@&@(&$(&$#)!(@*!)&*(#)(@d ad <a href="adsd">asdsd</a><img/><script>alert(1)</script>';
        echo strip_tags($html,'<br><p>');
    }
    
    public function actionGetManagePage(){
        $util = FacebookUtil::getInstance();
        var_dump($util->getManagePageList());
    }
    
    public function actionPostFanpage(){
        $product = Product::model()->findByPk(41);
        //https://www.facebook.com/pages/Nh%E1%BA%ADt-k%C3%BD-1-tri%E1%BB%87u-%C4%91%C3%B4/460822480658328?ref=hl#
        $data =FacebookUtil::getInstance()->shareProductToPage($product, '145218035666025');
        var_dump($data);
    }
    
    public function actionUrl(){
         $url = 'http://api.facebook.com/method/fql.query?query=select%20like_count%20from%20link_stat%20where%20url=%27http://www.imdb.com/title/tt0638423/%27&format=json';
        $productUrl = 'http://vnexpress.net/"';
        
        
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, ($url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data = curl_exec($ch);
            curl_close($ch);
            var_dump($data);
    }
    
    public function actionCurl(){
        FacebookPostQueueUtil::postByCurl('me1', 'post', array('access_token'=>'CAAE4ZAelsz4cBAKLqZBxvXQAFKnYJL3wOEwS4IaMKdHRzESR7pL2TEaLaApbHgfT7R3bdc9wukugtggAvJYpzra1zPZA7j83tpvMZBG6oIVYxaNpfXaZBHA8iJ34oGpuF5JtXxauI3CaMO1Dp2ejmT1ZArQLQdZBlUZD'));        
    }
    
    public function actionFbCron(){
        FacebookPostQueueUtil::processQueueList();
    }
}

?>
