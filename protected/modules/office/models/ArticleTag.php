<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use Yii;

/**
 * Модель связи тегов и статей
 *
 * Атрибуты
 * @property integer $id_article
 * @property integer $id_tag
 *
 * Связи
 * @property Article $article
 */
class ArticleTag extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_article_tags';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('id_article, id_tag', 'required'),
            array('id_article, id_tag', 'numerical', 'integerOnly' => true),
            array('id_article, id_tag', 'safe', 'on' => 'search'),
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
            'id_article' => 'ID статьи',
            'id_tag' => 'ID тега',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id_article', $this->id_article);
        $criteria->compare('id_tag', $this->id_tag);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Получение тега по ID
     * @param $id
     * @return mixed
     */
    public static function getTagName($id)
    {
        $sql = 'SELECT tag FROM db_tags WHERE id = ' . $id;
        $record = Yii::app()->db->createCommand($sql)->queryRow();
        return $record['tag'];
    }

    /**
     * Получение всех тегов
     * @return mixed
     */
    public static function getAllTags()
    {
        $sql = 'SELECT * FROM db_tags';
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        return array_column($records, 'tag', 'id');
    }

    /**
     * @param string $className
     * @return ArticleTag
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
