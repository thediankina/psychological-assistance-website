<?php

use application\modules\forum\models\Comment;
use application\modules\forum\models\Topic;
use application\modules\office\models\Article;
use application\modules\office\models\RequestHistory;

/**
 * Модель пользователя
 *
 * Атрибуты
 * @property integer $id
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 * @property string $phone
 * @property string $mail
 * @property integer $id_city
 * @property integer $id_position
 * @property string $password
 *
 * Связи
 * @property Article[] $articles
 * @property Comment[] $comments
 * @property Topic[] $topics
 * @property RequestHistory[] $histories
 * @property City $city
 * @property Position $position
 */
class User extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_users';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('firstName, lastName, mail, id_city, id_position', 'required'),
            array('id_city, id_position', 'numerical', 'integerOnly' => true),
            array('firstName, middleName, lastName, mail', 'length', 'max' => 45),
            array('phone', 'length', 'max' => 11),
            array('password', 'length', 'max' => 32),
            array(
                'id, firstName, middleName, lastName, phone, mail, id_city, id_position, password',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array[]
     */
    public function relations()
    {
        return array(
            'articles' => array(self::HAS_MANY, Article::class, 'id_author'),
            'comment' => array(self::HAS_ONE, 'Comment', 'id'),
            'topic' => array(self::HAS_ONE, 'Topic', 'id'),
            'histories' => array(self::HAS_MANY, RequestHistory::class, 'IDuser'),
            'city' => array(self::BELONGS_TO, City::class, 'id_city'),
            'position' => array(self::BELONGS_TO, Position::class, array('id_position' => 'id')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'firstName' => 'Имя',
            'middleName' => 'Отчество',
            'lastName' => 'Фамилия',
            'phone' => 'Телефон',
            'mail' => 'Электронная почта',
            'id_city' => 'Город',
            'id_position' => 'Специализация',
            'password' => 'Пароль',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('firstName', $this->firstName, true);
        $criteria->compare('middleName', $this->middleName, true);
        $criteria->compare('lastName', $this->lastName, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('id_city', $this->id_city);
        $criteria->compare('id_position', $this->id_position);
        $criteria->compare('password', $this->password, true);

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
