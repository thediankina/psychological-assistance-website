<?php

/**
 * Модель организации
 *
 * Атрибуты
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property string $phone
 * @property string $mail
 * @property integer $id_author
 * @property string $address
 * @property string $date_edit
 * @property string $site
 *
 * Связи
 * @property User $author
 */
class Organization extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_organization';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('name, id_author', 'required'),
            array('id_author', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('info', 'length', 'max' => 2000),
            array('phone', 'length', 'max' => 11),
            array('mail', 'length', 'max' => 20),
            array('address', 'length', 'max' => 200),
            array('site', 'length', 'max' => 150),
            array('date_edit', 'safe'),
            array('id, name, info, phone, mail, id_author, address, date_edit, site', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, User::class, 'id_author'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'info' => 'Описание',
            'phone' => 'Телефон',
            'mail' => 'Электронная почта',
            'id_author' => 'ID автора',
            'address' => 'Адрес',
            'date_edit' => 'Дата последнего редактирования',
            'site' => 'Сайт',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('info', $this->info, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('id_author', $this->id_author);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('date_edit', $this->date_edit, true);
        $criteria->compare('site', $this->site, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Organization
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
