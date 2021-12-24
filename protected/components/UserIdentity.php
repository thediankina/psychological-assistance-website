<?php

/**
 * Будущий класс для проверки доступа
 * @package components
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function getId()
    {
        return $this->_id;
    }

	/**
	 * Условная аутентификация пользователя
	 * @return boolean
	 */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(array(
            'username' => $this->username,
        ));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$this->password === $user->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $user->id;
        }
        return !$this->errorCode;
    }
}