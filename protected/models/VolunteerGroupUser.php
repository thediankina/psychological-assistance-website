<?php

/**
 * Модель соответствия волонтера группе
 *
 * Атрибуты
 * @property integer $id
 * @property integer $volunteer_id
 * @property integer $group_id
 * @property integer $param_value
 *
 * Связи
 * @property VolunteerGroup $group
 * @property Volunteer $volunteer
 */
class VolunteerGroupUser extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_users_group_volunteer';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('volunteer_id, group_id, param_value', 'required'),
            array('volunteer_id, group_id, param_value', 'numerical', 'integerOnly' => true),
            array('id, volunteer_id, group_id, param_value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'group' => array(self::BELONGS_TO, VolunteerGroup::class, 'group_id'),
            'volunteer' => array(self::BELONGS_TO, Volunteer::class, 'volunteer_id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'volunteer_id' => 'Волонтер',
            'group_id' => 'Группа',
            'param_value' => 'Признак',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array('group');
        $criteria->compare('id', $this->id);
        $criteria->compare('volunteer_id', $this->volunteer_id);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('param_value', $this->param_value);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return VolunteerGroupUser
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
