<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use City;

/**
 * Модель заявки
 *
 * Атрибуты
 * @property integer $id
 * @property string $name
 * @property integer $id_category
 * @property string $info
 * @property string $email
 * @property string $phone
 * @property string $status
 * @property integer $old
 * @property integer $id_city
 *
 * Связи
 * @property Category $category
 * @property City $city
 * @property RequestHistory[] $history
 */
class Request extends CActiveRecord
{
    /**
     * ID пользователя для поиска исполняемых им заявок
     * @var integer
     */
    public $executor_id;

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
            array('name, id_category, info, status, id_city', 'required'),
            array('id_category, old, id_city', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('info', 'length', 'max' => 2000),
            array('email', 'length', 'max' => 20),
            array('phone', 'length', 'max' => 11),
            array('status', 'length', 'max' => 26),
            array('id, name, id_category, info, email, phone, status, old, id_city', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array[]
     */
    public function relations()
    {
        return array(
            'category' => array(
                self::BELONGS_TO,
                Category::class,
                array('id_category' => 'id'),
                'select' => 'category_name, priority',
            ),
            'executor' => array(
                self::HAS_ONE,
                RequestHistory::class,
                array('IDrequest' => 'id'),
                'with' => array('user'),
            ),
            'city' => array(self::BELONGS_TO, City::class, array('id_city' => 'id')),
            'history' => array(self::HAS_MANY, RequestHistory::class, array('id' => 'IDrequest')),
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
            'info' => 'Описание',
            'email' => 'Электронная почта',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'old' => 'Возраст',
            'id_city' => 'ID города',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('category', 'executor', 'city');
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('category.id', $this->id_category);
        $criteria->compare('info', $this->info, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('old', $this->old);
        $criteria->compare('city.id',$this->id_city);

        if ($this->executor_id) {
            $criteria->addCondition('`executor`.IDuser =' . $this->executor_id . ' AND `t`.status != "Отклонена"');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
            'sort' => array(
                'attributes' => array(
                    'id',
                    'category.category_name',
                    'category.priority',
                    'status',
                    'city.name',
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
