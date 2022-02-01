<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * Модель статусов статьи
 *
 * Атрибуты
 * @property integer $id
 * @property string $status
 *
 * Связи
 * @property Article[] $articles
 */
class ArticleStatus extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_status_article';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('status', 'required'),
            array('status', 'length', 'max' => 44),
            array('id, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'articles' => array(self::HAS_MANY, Article::class, array('id' => 'id_status')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'status' => 'Статус',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return ArticleStatus
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
