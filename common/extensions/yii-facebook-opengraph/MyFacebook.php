<?php 
require_once 'SFacebook.php';
class MyFacebook extends SFacebook{
	public $profile;

	public function getProfile(){
		if($this->profile == null){
			$this->profile = $this->_getFacebook()->api('/me');  
		}
		return $this->profile;
	}
}