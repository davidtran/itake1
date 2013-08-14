<?php 
require_once 'SFacebook.php';
require_once 'ItakeSBaseFacebook.php';
class ItakeSFacebook extends SFacebook{
	/*** PHP SDK functions **/
    protected $_client;
  /**
   * @throws CException if the Facebook PHP SDK cannot be loaded
   * @return instance of Facebook PHP SDK class
   */
  public function _getFacebook()
  {    
     
    if (is_null($this->_client)) {
      if ($this->appId && $this->secret) {
        $this->_client = new ItakeSBaseFacebook(
          array(
            'appId' => $this->appId,
            'secret' => $this->secret,
            'fileUpload' => $this->fileUpload,
            'trustForwarded' => $this->trustForwarded,
          ));
      } else {
        if (!$this->appId)
          throw new CException('Facebook application ID not specified.');
        elseif (!$this->secret)
          throw new CException('Facebook application secret not specified.');
      }
    }
    if(!is_object($this->_client)) {
      throw new CException('Facebook API could not be initialized.');
    }
    return $this->_client;
  }
  
  public function getProfile(){
      return $this->_getFacebook()->api('/me','post');
  }
    
}