<?php

/**
 * Модель групп волонтеров
 *
 * Атрибуты
 * @property integer $id
 * @property string $short_name
 * @property string $group_name
 *
 * Связи
 * @property Volunteer[] $volunteers
 * @property VolunteerGroupUser[] $groups
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
            array('short_name, group_name', 'required'),
            array('short_name', 'length', 'max' => 30),
            array('group_name', 'length', 'max' => 70),
            array('id, short_name, group_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'volunteers' => array(self::HAS_MANY, Volunteer::class, array('id_group' => 'id')),
            'groups' => array(self::HAS_MANY, VolunteerGroupUser::class, 'group_id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'short_name' => 'Краткое название',
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
        $criteria->compare('short_name', $this->short_name, true);
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
