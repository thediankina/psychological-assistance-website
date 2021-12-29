<?php

/**
 * Модель пользователя
 *
 * Атрибуты
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class User extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_user';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('username, password', 'required'),
            array('username, password', 'length', 'max' => 255),
            array('email', 'length', 'max' => 100),
            array('profile', 'safe'),
            array('id, username, password, email, profile', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Пользователь',
            'password' => 'Пароль',
            'email' => 'Электронная почта',
            'profile' => 'Профиль',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('profile', $this->profile, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return User
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
