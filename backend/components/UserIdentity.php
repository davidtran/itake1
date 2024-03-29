<?php
/**
 * UserIdentity.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 8/12/12
 * Time: 10:00 PM
 */
class UserIdentity extends CUserIdentity {
	/**
	 * @var integer id of logged user
	 */
	private $_id;

	/**
	 * Authenticates username and password
	 * @return boolean CUserIdentity::ERROR_NONE if successful authentication
	 */
	public function authenticate() {
		$attribute = strpos($this->username, '@') ? 'email' : 'username';
		$user = User::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;            
		} else if ($user->password != $user->makeOptimizedPassword($this->password,$user->salt)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;            
		} else {			          
			$this->_id = $user->id;
			$this->username = $user->email;			
			$this->errorCode = self::ERROR_NONE;        
		}
        
		return !$this->errorCode;
	}

	/**
	 * Creates an authenticated user with no passwords for registration
	 * process (checkout)
	 * @param string $username
	 * @return self
	 */
	public static function createAuthenticatedIdentity($id, $username) {
		$identity = new self($username, '');
		$identity->_id = $id;
		$identity->errorCode = self::ERROR_NONE;
		return $identity;
	}

	/**
	 *
	 * @return integer id of the logged user, null if not set
	 */
	public function getId() {
		return $this->_id;
	}
}