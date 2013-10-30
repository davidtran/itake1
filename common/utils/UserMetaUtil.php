<?php
class UserMetaUtil{
    const POST_LIMIT = 'PostLimit';
    
    public static $updatableMetaList = array(
        self::POST_LIMIT=>'Post per day'
    );
    //get and set, delete
	public static function setMeta($user_id,$key,$value,$subKey = null){
		$meta = self::findMeta($user_id,$key,$subKey);
		if($meta==null){
			$meta = new Usermeta();	
			$meta->user_id = $user_id;
			$meta->key = $key;
			if($subKey!=null){
				$meta->sub_key = $subKey;
			}
		}
		$meta->value = serialize($value);
		if($meta->save()){
			return $meta;	
		}else{
			return false;
		}		
	}

	public static function findMeta($user_id, $key, $subKey = null)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('user_id', $user_id);
		$criteria->compare('`key`',$key);
		$criteria->compare('sub_key',$subKey);
		$meta = Usermeta::model()->find($criteria);
        if($meta!=null){            
            $meta->value = unserialize($meta->value);                        
        }
		return $meta;
	}
    
	public static function deleteMeta($user_id,$key,$subKey = null){
		$meta = self::findMeta($user_id,$key,$subKey);
		if($meta) $meta->delete();
	}
    
    public static function updateMetaByPost($user){
        foreach(self::$updatableMetaList as $key=>$label){
            $value = Yii::app()->request->getPost($key);
            if($value!=null){
                self::setMeta($user->id, $key, $value);
            }
        }
    }
    
    public static function renderMetaInput($type,$options = array(),$user,$key,$subkey=null){
        foreach(self::$updatableMetaList as $allowedKey=>$label){
            if($key == $allowedKey){
                $meta = self::findMeta($user->id, $key);
                $value = null;
                
                if($meta != null){
                    $value = $meta->value;
                }
                $html = '<label>'.$label.'</label>';
                switch($type){
                    case 'textfield':
                        $html .= CHtml::textField($key,$value,$options);
                        break;
                    case 'textarea':
                        $html .= CHtml::textField($key,$value,$options);
                        break;
                    default:
                        $html .= CHtml::textField($key,$value,$options);
                        break;                
                }
                return $html;
            }                        
        }
        throw new CException('This meta can not be edit');
        
        
    }
    
    

	
}