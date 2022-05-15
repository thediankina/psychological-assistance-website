<?php

namespace application\modules\forum\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * Модель категории обсуждения
 *
 * Атрибуты
 * @property integer $id
 * @property string $name
 *
 * Связи
 * @property Topic $topic
 */
class Category extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_category_top';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 20),
            array('id, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'topic' => array(self::BELONGS_TO, Topic::class, 'id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Категория',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Category
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
