<?php

namespace application\modules\forum\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use User;

/**
 * Модель обсуждения
 *
 * Атрибуты
 * @property integer $id
 * @property integer $id_forum
 * @property string $title
 * @property integer $id_category
 * @property integer $id_author
 * @property string $public_date
 *
 * Связи
 * @property Category $category
 * @property Comment[] $comments
 * @property Forum $forum
 * @property User $author
 */
class Topic extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_topic';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('id_forum, id_author', 'required'),
            array('id_forum, id_category, id_author', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('public_date', 'safe'),
            array('id, id_forum, title, id_category, id_author, public_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'category' => array(self::HAS_ONE, Category::class, array('id_category' => 'id')),
            'comments' => array(
                self::HAS_MANY,
                Comment::class,
                array('id_topic' => 'id'),
                'order' => 'comments.public_date ASC'
            ),
            'forum' => array(self::HAS_ONE, Forum::class, array('id_forum' => 'id')),
            'author' => array(self::BELONGS_TO, User::class, array('id_author' => 'id')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_forum' => 'ID форума',
            'title' => 'Тема',
            'id_category' => 'ID категории',
            'id_author' => 'ID автора',
            'public_date' => 'Дата',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('id_forum', $this->id_forum);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('id_category', $this->id_category);
        $criteria->compare('id_author', $this->id_author);
        $criteria->compare('public_date', $this->public_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Topic
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
