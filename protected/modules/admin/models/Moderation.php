<?php

namespace application\modules\admin\models;

use application\modules\office\models\Article;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * Модель модерации статьи
 * Подразумевает запись действия администратора над статьей
 *
 * Атрибуты
 * @property integer $id
 * @property string $comment
 * @property string $date
 * @property integer $id_article
 *
 * Связи
 * @property Article $article
 */
class Moderation extends CActiveRecord
{
    const ADMIN_PANEL_CATEGORIES = array(
        array(
            'id' => 1,
            'name' => 'Запросы на регистрацию',
            'link' => '/admin/users',
            'description' => 'Рассмотреть запросы специалистов на регистрацию в системе',
        ),
        array(
            'id' => 2,
            'name' => 'Модерация статей',
            'link' => '/admin/articles',
            'description' => 'Рассмотреть статьи, поданные на публикацию',
        ),
        array(
            'id' => 3,
            'name' => 'Список волонтеров',
            'link' => '/admin/volunteers',
            'description' => 'Рассмотреть профили волонтеров, зарегистрированных в системе',
        ),
        array(
            'id' => 4,
            'name' => 'Редактирование форума',
            'link' => '/admin/forums',
            'description' => 'Рассмотреть разделы форума',
        ),
    );

    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_moderation';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('id_article', 'required'),
            array('id_article', 'numerical', 'integerOnly' => true),
            array('comment', 'length', 'max' => 500),
            array('date', 'safe'),
            array('id, comment, date, id_article', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'article' => array(self::BELONGS_TO, Article::class, 'id_article'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'comment' => 'Комментарий',
            'date' => 'Дата',
            'id_article' => 'ID статьи',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('id_article', $this->id_article);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param $article
     * @param $comment
     * @return Moderation
     */
    public static function createRecord($article, $comment)
    {
        $record = new Moderation();
        $record->comment = $comment;
        $record->date = date('Y-m-d');
        $record->id_article = $article->id;

        return $record;
    }

    /**
     * @param string $className
     * @return Moderation
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
