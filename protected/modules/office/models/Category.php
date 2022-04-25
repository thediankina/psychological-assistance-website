<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use User;

/**
 * Модель категории заявки
 *
 * Атрибуты
 * @property integer $id
 * @property integer $id_parent
 * @property string $priority
 * @property string $category_name
 * @property integer $id_author
 * @property string $date_edit
 *
 * Связи
 * @property Article[] $articles
 * @property User $author
 * @property Request[] $requests
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
            array('id_parent, priority, category_name', 'required'),
            array('id_parent, id_author', 'numerical', 'integerOnly' => true),
            array('priority', 'length', 'max' => 14),
            array('category_name', 'length', 'max' => 150),
            array('date_edit', 'safe'),
            array('id, id_parent, priority, category_name, id_author, date_edit', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'articles' => array(self::HAS_MANY, Article::class, array('id' => 'id_category_article')),
            'author' => array(self::BELONGS_TO, User::class, array('id_author' => 'id')),
            'requests' => array(self::HAS_MANY, Request::class, array('id' => 'id_category')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_parent' => 'ID родительской категории',
            'priority' => 'Приоритет',
            'category_name' => 'Категория',
            'id_author' => 'ID автора',
            'date_edit' => 'Дата последнего редактирования',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('id_parent',$this->id_parent);
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
