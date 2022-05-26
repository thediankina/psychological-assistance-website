<?php

/**
 * @package components
 */
class WebUser extends CWebUser
{
    private $_model = null;

    function getRole()
    {
        if ($user = $this->getModel()) {
            return $user->id_position;
        }
        return User::ROLE_GUEST;
    }

    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByAttributes(array(
                'id' => $this->id,
                'isActive' => User::STATUS_ENABLED
            ), array('select' => 'id_position'));
        }
        return $this->_model;
    }
}
