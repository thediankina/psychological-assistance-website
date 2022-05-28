<?php

use application\modules\forum\models\Comment;
use application\modules\forum\models\Topic;
use application\modules\office\models\Article;
use application\modules\office\models\Category;
use application\modules\office\models\RequestHistory;

/**
 * Модель пользователя
 *
 * Атрибуты
 * @property integer $id
 * @property integer $isActive
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 * @property string $phone
 * @property string $mail
 * @property integer $id_city
 * @property integer $id_position
 * @property string $password
 * @property string $salt
 *
 * Связи
 * @property Article[] $articles
 * @property Category[] $categories
 * @property Comment[] $comments
 * @property Organization[] $organizations
 * @property Topic[] $topics
 * @property RequestHistory[] $histories
 * @property City $city
 * @property Position $position
 * @property Volunteer $volunteer
 */
class User extends CActiveRecord
{
    /**
     * Статус пользователя
     * 1 = Активен
     * 0 = Отключен
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const ROLE_GUEST = 'guest';
    const ROLE_PSYCHOLOGIST = 1;
    const ROLE_LAWYER = 2;
    const ROLE_ADMINISTRATOR = 5;
    const ROLE_VOLUNTEER = 6;

    const ROLES_SPECIALIST = array(
        self::ROLE_PSYCHOLOGIST,
        self::ROLE_LAWYER,
    );

    const ROLES_ANYBODY = array(
        self::ROLE_GUEST,
        self::ROLES_SPECIALIST,
        self::ROLE_VOLUNTEER,
        );

    const ROLES_ALL = array(
        self::ROLE_GUEST,
        self::ROLE_PSYCHOLOGIST,
        self::ROLE_LAWYER,
        self::ROLE_ADMINISTRATOR,
        self::ROLE_VOLUNTEER,
    );

    const VOLUNTEER_POSITION = 6;

    // @todo Перенести в форму UserForm

    /**
     * Статус активности волонтера
     * @var integer
     */
    public $activity;

    /**
     * Возраст волонтера
     * @var integer
     */
    public $old;

    /**
     * Ссылка, которую указывает волонтер
     * @var integer
     */
    public $site;

    /**
     * Группы волонтера
     * @var array
     */
    public $groupIds;

    /**
     * Другое
     * @var integer
     */
    public $other;

    /**
     * Дополнительные возможности волонтера
     * @var string
     */
    public $utility;

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
            array('firstName, middleName, lastName, phone, mail, id_city, id_position, password', 'required'),
            array('isActive, id_city, id_position, activity', 'numerical', 'integerOnly' => true),
            array('firstName, middleName, lastName, mail', 'length', 'max' => 45),
            array('phone', 'length', 'max' => 11),
            array('password, salt', 'length', 'max' => 32),
            array('utility', 'length', 'max' => 200),
            array('other', 'length', 'max' => 50),
            array(
                'id, isActive, firstName, middleName, lastName, phone, mail, id_city, id_position, password, salt, other, utility, activity',
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
            'categories' => array(self::HAS_MANY, Category::class, 'id_author'),
            'comment' => array(self::HAS_MANY, Comment::class, 'id'),
            'organizations' => array(self::HAS_MANY, Organization::class, 'id_author'),
            'topic' => array(self::HAS_MANY, Topic::class, 'id'),
            'histories' => array(self::HAS_MANY, RequestHistory::class, 'IDuser'),
            'city' => array(self::BELONGS_TO, City::class, array('id_city' => 'id')),
            'position' => array(self::BELONGS_TO, Position::class, array('id_position' => 'id')),
            'volunteer' => array(self::HAS_ONE, Volunteer::class, 'id', 'with' => array('groups')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'isActive' => 'Статус',
            'firstName' => 'Имя',
            'middleName' => 'Отчество',
            'lastName' => 'Фамилия',
            'phone' => 'Телефон',
            'mail' => 'Электронная почта',
            'id_city' => 'Город',
            'id_position' => 'Специализация',
            'password' => 'Пароль',
            'salt' => '',
            'groupIds' => 'Волонтерские группы',
            'other' => 'Другое',
            'utility' => 'Дополнительно',
            'activity' => 'Статус',
            'site' => 'Социальная сеть',
            'old' => 'Возраст',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array('volunteer');
        $criteria->compare('id', $this->id);
        $criteria->compare('isActive',$this->isActive);
        $criteria->compare('firstName', $this->firstName, true);
        $criteria->compare('middleName', $this->middleName, true);
        $criteria->compare('lastName', $this->lastName, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('id_city', $this->id_city);
        $criteria->compare('id_position', $this->id_position);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('other', $this->other, true);
        $criteria->compare('utility', $this->utility, true);
        $criteria->compare('activity', $this->activity);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * Верификация волонтера
     * @return bool
     */
    public function isVolunteer() {
        return $this->id_position == self::VOLUNTEER_POSITION;
    }

    /**
     * Получение названий групп волонтера в виде строки
     * @return string|null
     */
    public function getVolunteerGroups() {
        $groups = array();
        $links = VolunteerGroupUser::model()->findAllByAttributes(array('volunteer_id' => $this->id));
        if (!empty($links)) {
            foreach ($links as $link) {
                $group = VolunteerGroup::model()->findByPk($link->group_id);
                $groups[] = $group->group_name;
            }
        }

        return $groups ? implode(PHP_EOL, $groups) : null;
    }

    /**
     * Получение ИД групп волонтера
     * @return array
     */
    public function getVolunteerGroupIds() {
        $groupIds = array();
        $links = VolunteerGroupUser::model()->findAllByAttributes(array('volunteer_id' => $this->id));
        if (!empty($links)) {
            foreach ($links as $link) {
                $group = VolunteerGroup::model()->findByPk($link->group_id);
                $groupIds[] = $group->id;
            }
        }

        return $groupIds;
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
