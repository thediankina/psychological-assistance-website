<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use CDbExpression;
use User;

/**
 * Модель статьи
 *
 * Атрибуты
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $id_author
 * @property string $dates_temp
 * @property integer $id_status
 * @property integer $id_category_article
 *
 * Связи
 * @property User $author
 * @property Category $category
 * @property ArticleStatus $status
 */
class Article extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_article';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('title, content, id_author, id_status, id_category_article', 'required'),
            array('id_author, id_status, id_category_article', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('dates_temp', 'safe'),
            array(
                'id, title, content, id_author, dates_temp, id_status, id_category_article',
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
            'author' => array(self::BELONGS_TO, User::class, array('id_author' => 'id')),
            'category' => array(self::BELONGS_TO, Category::class, array('id_category_article' => 'id')),
            'status' => array(self::BELONGS_TO, ArticleStatus::class, array('id_status' => 'id')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название',
            'content' => 'Содержание',
            'id_author' => 'ID автора',
            'dates_temp' => 'Дата',
            'id_status' => 'ID статуса',
            'id_category_article' => 'ID категории',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array('author', 'status');
        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('author.id', $this->id_author);
        $criteria->compare('dates_temp',$this->dates_temp,true);
        $criteria->compare('status.status',$this->id_status);
        $criteria->compare('category.id',$this->id_category_article);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 30),
            'sort' => array(
                'attributes' => array(
                    'id',
                    'title',
                    'category.category_name',
                    'content',
                    'status.status',
                    'dates_temp',
                )
            ),
        ));
    }

    /**
     * @param string $className
     * @return Article
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->dates_temp = new CDbExpression('NOW()');

        return parent::beforeSave();
    }
}
