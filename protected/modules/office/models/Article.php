<?php

/**
 * Модель "Статья" в личном кабинете
 *
 * Атрибуты
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $id_author
 * @property string $dates_temp
 * @property string $status
 *
 * Связи
 * @property User $author
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
            array('title, content, id_author, status', 'required'),
            array('id_author', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('status', 'length', 'max' => 24),
            array('dates_temp', 'safe'),
            array('id, title, content, id_author, dates_temp, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'id_author'),
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
            'dates_temp' => 'Дата создания',
            'status' => 'Статус',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('author.id', $this->id_author);
        $criteria->compare('dates_temp', $this->dates_temp, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 30),
            'sort' => array(
                'attributes' => array(
                    'id',
                    'title',
                    'content',
                    'author.id',
                    'dates_temp',
                    'status'
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
}
