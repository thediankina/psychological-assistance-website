<?php

use application\modules\office\models\Request;

/**
 * Модель города
 *
 * Атрибуты
 * @property integer $id
 * @property integer $indexDep
 * @property string $address
 * @property string $phoneDep
 * @property string $name
 *
 * Связи
 * @property Request[] $requests
 * @property User[] $users
 * @property Volunteer[] $volunteers
 */
class City extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_city';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('indexDep, address, name', 'required'),
            array('indexDep', 'numerical', 'integerOnly' => true),
            array('address', 'length', 'max' => 100),
            array('phoneDep, name', 'length', 'max' => 128),
            array('id, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'requests' => array(self::HAS_MANY, Request::class, 'id_city'),
            'users' => array(self::HAS_MANY, User::class, 'id_city'),
            'volunteers' => array(self::HAS_MANY, Volunteer::class, 'id_city'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'indexDep' => 'Index Dep',
            'address' => 'Address',
            'phoneDep' => 'Phone Dep',
            'name' => 'Город',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('indexDep', $this->indexDep);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phoneDep', $this->phoneDep, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return City
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
