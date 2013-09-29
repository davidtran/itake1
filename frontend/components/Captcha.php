<?php

class Captcha extends CCaptcha{
    
    public function run()
	{
		if(self::checkRequirements())
		{
			$this->renderImage();
            $this->renderButton();
			$this->registerClientScript();
		}
		else
			throw new CException(Yii::t('yii','GD and FreeType PHP extensions are required.'));
	}
    /**
	 * Registers the needed client scripts.
	 */
	public function registerClientScript()
	{
		$cs=Yii::app()->clientScript;
		$id=$this->imageOptions['id'];
		$url=$this->getController()->createUrl($this->captchaAction,array(CCaptchaAction::REFRESH_GET_VAR=>true));

		$js="";
		if($this->showRefreshButton)
		{		
			$selector="#$this->buttonId";
		}

		if($this->clickableImage)
			$selector=isset($selector) ? "$selector, #$id" : "#$id";

		if(!isset($selector))
			return;

		$js.="

$('$selector').live('click', function(e){
    e.preventDefault();
	$.ajax({
		url: ".CJSON::encode($url).",
		dataType: 'json',
		cache: false,
		success: function(data) {
        
			$('#$id').attr('src', data['url']);
			$('body').data('{$this->captchaAction}.hash', [data['hash1'], data['hash2']]);
		}
	});
	return false;
});

";
            
            $js = '<script>'.$js.'</script>';
		echo $js;
	}
    
    protected $buttonId;
    
    protected function renderButton(){
        $id=$this->imageOptions['id'];
        $url=$this->getController()->createUrl($this->captchaAction,array(CCaptchaAction::REFRESH_GET_VAR=>true));
        if($this->showRefreshButton)
		{
			// reserve a place in the registered script so that any enclosing button js code appears after the captcha js
	
			$label=$this->buttonLabel===null?Yii::t('yii','Get a new code'):$this->buttonLabel;
			$options=$this->buttonOptions;
			if(isset($options['id']))
				$buttonID=$options['id'];
			else
				$buttonID=$options['id']=$id.'_button';
			if($this->buttonType==='button')
				$html=CHtml::button($label, $options);
			else
				$html=CHtml::link($label, $url, $options);
			
			$this->buttonId = $buttonID;
            echo $html;
		}
        return null;
    }
}