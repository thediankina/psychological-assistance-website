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
 * @property Volunteer $volunteer
 */
class User extends CActiveRecord
{
    /**
     * Дополнительные возможности волонтера
     * @var string
     */
    public $utility;

    /**
     * Группа, к которой относится волонтер
     * @var integer
     */
    public $id_group;

    /**
     * Статус активности волонтера
     * @var integer
     */
    public $activity;

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
            array('id_city, id_position, id_group, activity', 'numerical', 'integerOnly' => true),
            array('firstName, middleName, lastName, mail', 'length', 'max' => 45),
            array('phone', 'length', 'max' => 11),
            array('password', 'length', 'max' => 32),
            array('utility', 'length', 'max' => 200),
            array(
                'id, firstName, middleName, lastName, phone, mail, id_city, id_position, password, id_group, utility, activity',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'articles' => array(self::HAS_MANY, Article::class, 'id_author'),
            'comment' => array(self::HAS_ONE, Comment::class, 'id'),
            'topic' => array(self::HAS_ONE, Topic::class, 'id'),
            'histories' => array(self::HAS_MANY, RequestHistory::class, 'IDuser'),
            'city' => array(self::BELONGS_TO, City::class, array('id_city' => 'id')),
            'position' => array(self::BELONGS_TO, Position::class, array('id_position' => 'id')),
            'volunteer' => array(self::HAS_ONE, Volunteer::class, 'id', 'with' => array('group')),
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
            'id_group' => 'Волонтерская группа',
            'utility' => 'Другое',
            'activity' => 'Статус',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('volunteer');
        $criteria->compare('id', $this->id);
        $criteria->compare('firstName', $this->firstName, true);
        $criteria->compare('middleName', $this->middleName, true);
        $criteria->compare('lastName', $this->lastName, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('id_city', $this->id_city);
        $criteria->compare('id_position', $this->id_position);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('id_group', $this->id_group);
        $criteria->compare('utility', $this->utility, true);
        $criteria->compare('activity', $this->activity);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
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
