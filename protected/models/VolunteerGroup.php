<?php

/**
 * Модель групп волонтеров
 *
 * Атрибуты
 * @property integer $id
 * @property string $group_name
 *
 * Связи
 * @property Volunteer[] $volunteers
 */
class VolunteerGroup extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_group_volunteer';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('group_name', 'required'),
            array('group_name', 'length', 'max' => 70),
            array('id, group_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'volunteers' => array(self::HAS_MANY, Volunteer::class, array('id_group' => 'id')),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'group_name' => 'Название',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('group_name', $this->group_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return VolunteerGroup
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
