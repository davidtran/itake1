<?php
class UserMetaUtil{
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
		$meta->value = $value;
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
		return $meta;
	}
	public static function deleteMeta($user_id,$key,$subKey = null){
		$meta = self::findMeta($user_id,$key,$subKey);
		if($meta) $meta->delete();
	}

	
}