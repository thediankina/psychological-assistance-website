<?php

/**
 * Модель специализаций пользователей
 *
 * Атрибуты
 * @property integer $id
 * @property string $namePosition
 *
 * Связи
 * @property User[] $users
 */
class Position extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_spec_position';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('namePosition', 'required'),
            array('namePosition', 'length', 'max' => 35),
            array('id, namePosition', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::HAS_MANY, User::class, array('id' => 'id_position')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'namePosition' => 'Специализация',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('namePosition', $this->namePosition, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Position
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
