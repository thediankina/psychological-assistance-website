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
 */
class CategoryRequest extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_category_req';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('priority, category_name', 'required'),
            array('priority', 'length', 'max'=>1),
            array('category_name', 'length', 'max'=>30),
            array('id, priority, category_name', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('priority',$this->priority,true);
        $criteria->compare('category_name',$this->category_name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * @param string $className
     * @return CategoryRequest
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
