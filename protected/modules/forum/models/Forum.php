<?php

namespace application\modules\forum\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * Модель раздела форума
 *
 * Атрибуты
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * Связи
 * @property Topic $topic
 */
class Forum extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_forum';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 200),
            array('description', 'length', 'max' => 2000),
            array('id, title, description', 'safe', 'on' => 'search'),
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
            'title' => 'Тема',
            'description' => 'Описание',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Forum
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
