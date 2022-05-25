<?php

namespace application\modules\office\models;

use application\modules\admin\models\Moderation;
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
 * @property string $type
 *
 * Связи
 * @property ArticleTag[] $tags
 * @property Category $category
 * @property ArticleStatus $status
 * @property User $author
 * @property Moderation[] $moderations
 */
class Article extends CActiveRecord
{
    const PUBLISHED_STATUS = 1; // Опубликовано
    const DRAFT_STATUS = 2; // Черновик
    const VERIFICATION_STATUS = 3;  // На модерации
    const MODIFY_STATUS = 4;    // Отправлено на доработку

    /**
     * Типы статей
     * @var array
     */
    public $types = array(
        'psychological' => 'Психологическая помощь',
        'law' => 'Юридическая помощь'
    );

    /**
     * Выбранные теги
     * @var array
     */
    public $chosenTags;

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
            array('title, content, id_author, id_status, id_category_article, type', 'required'),
            array('id_author, id_status, id_category_article', 'numerical', 'integerOnly' => true),
            array('content', 'length', 'max' => 50000),
            array('title', 'length', 'max' => 100),
            array('type', 'length', 'max' => 13),
            array('dates_temp', 'safe'),
            array(
                'id, title, content, id_author, dates_temp, id_status, id_category_article, type',
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
            'tags' => array(self::HAS_MANY, ArticleTag::class, 'id_article'),
            'category' => array(self::BELONGS_TO, Category::class, array('id_category_article' => 'id')),
            'status' => array(self::BELONGS_TO, ArticleStatus::class, array('id_status' => 'id')),
            'author' => array(self::BELONGS_TO, User::class, array('id_author' => 'id')),
            'moderations' => array(
                self::HAS_ONE,
                Moderation::class,
                array('id_article' => 'id'),
                'order' => 'moderations.id DESC',
            ),
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
            'type' => 'Тип',
            'chosenTags' => 'Теги',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array('author', 'status');
        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('author.id', $this->id_author);
        $criteria->compare('dates_temp', $this->dates_temp, true);
        $criteria->compare('status.status', $this->id_status);
        $criteria->compare('category.id', $this->id_category_article);
        $criteria->compare('type', $this->type, true);

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
     * Получение тегов статьи
     * @return array
     */
    public function getTags()
    {
        $records = ArticleTag::model()->findAllByAttributes(array('id_article' => $this->id));
        return array_column($records, 'id_tag');
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
