<?php

use application\modules\office\models\Article;

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
     * @param string $className
     * @return Moderation
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
