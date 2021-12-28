<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use City;
use User;

/**
 * Модель заявки
 *
 * Атрибуты
 * @property integer $id
 * @property string $name
 * @property integer $id_category
 * @property string $body
 * @property integer $id_city
 * @property string $email
 * @property integer $phone
 * @property string $comment
 * @property string $status
 * @property integer $id_user
 *
 * Связи
 * @property CategoryRequest $category
 * @property City $city
 * @property User $user
 */
class Request extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_request';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('name, id_category, body, id_city, status', 'required'),
            array('id_category, phone, id_user', 'numerical', 'integerOnly' => true),
            array('email, status', 'length', 'max' => 20),
            array('comment', 'length', 'max' => 100),
            array(
                'id, name, id_category, body, id_city, email, phone, comment, status, id_user',
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
            'category' => array(self::HAS_ONE, CategoryRequest::class, array('id' => 'id_category')),
            'city' => array(self::HAS_ONE, City::class, array('id' => 'id_city')),
            'user' => array(self::HAS_ONE, User::class, array('id' => 'id_user'))
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Имя/Псевдоним',
            'id_category' => 'ID категории',
            'body' => 'Описание',
            'id_city' => 'ID города',
            'email' => 'Электронная почта',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'id_user' => 'Назначено',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('category', 'city', 'user');
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name);
        $criteria->compare('category.id', $this->id_category);
        $criteria->compare('city.id', $this->id_city);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('user.id', $this->id_user, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
            'sort' => array(
                'attributes' => array(
                    'id',
                    'city.name',
                    'category.category_name',
                    'category.priority',
                    'status',
                    'user.username'
                )
            ),
        ));
    }

    /**
     * @param string $className
     * @return Request
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
