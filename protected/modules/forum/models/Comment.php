<?php

namespace application\modules\forum\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use User;

/**
 * Модель комментария к обсуждению
 *
 * Атрибуты
 * @property integer $id
 * @property integer $id_topic
 * @property string $content
 * @property integer $id_author
 * @property string $public_date
 *
 * Связи
 * @property Topic $topic
 * @property User $author
 */
class Comment extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_comment';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('id_topic', 'required'),
            array('id_author', 'required', 'message' => 'Вы неавторизованы'),
            // content является обязательным, т.к. нельзя хранить пустые комментарии
            array(
                'content',
                'required',
                'message' => 'Вы пытаетесь добавить пустой комментарий'
            ),
            array('id_topic, id_author', 'numerical', 'integerOnly' => true),
            array('content', 'length', 'max' => 2000),
            array('public_date', 'safe'),
            array('id, id_topic, content, id_author, public_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'topic' => array(self::BELONGS_TO, Topic::class, 'id_topic'),
            'author' => array(self::BELONGS_TO, User::class, array('id_author' => 'id'), 'with' => array('position', 'city')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_topic' => 'Обсуждение',
            'content' => 'Содержание',
            'id_author' => 'ID автора',
            'public_date' => 'Дата публикации',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('author');
        $criteria->compare('id', $this->id);
        $criteria->compare('id_topic', $this->id_topic);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('id_author', $this->id_author);
        $criteria->compare('public_date', $this->public_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Comment
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
