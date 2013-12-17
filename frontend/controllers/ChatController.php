<?php

class ChatController extends Controller
{
	public function actionIndex(){
		$this->checkLogin('Vui lòng đăng nhập khi sử dụng chức năng này');
		$this->render('index', array(
            
        ));
	}
}