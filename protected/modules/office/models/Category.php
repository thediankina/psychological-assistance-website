<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * Модель категории заявки
 *
 * Атрибуты
 * @property integer $id
 * @property string $priority
 * @property string $category_name
 * @property integer $id_author
 * @property string $date_edit
 *
 * Связи
 * @property Request $request
 */
class Category extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_category';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('priority, category_name', 'required'),
            array('id_author', 'numerical', 'integerOnly' => true),
            array('priority', 'length', 'max' => 14),
            array('category_name', 'length', 'max' => 30),
            array('date_edit', 'safe'),
            array('id, priority, category_name, id_author, date_edit', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'request' => array(self::BELONGS_TO, Request::class, 'id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'priority' => 'Приоритет',
            'category_name' => 'Категория',
            'id_author' => 'Id Author',
            'date_edit' => 'Date Edit',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('priority', $this->priority, true);
        $criteria->compare('category_name', $this->category_name, true);
        $criteria->compare('id_author', $this->id_author);
        $criteria->compare('date_edit', $this->date_edit, true);

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
