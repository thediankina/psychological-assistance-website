<?php

/**
 * Модель дополнительной информации для волонтеров
 *
 * Атрибуты
 * @property integer $id
 * @property string $other
 * @property integer $old
 * @property string $utility
 * @property string $site
 * @property integer $id_city
 *
 * Связи
 * @property VolunteerGroupUser[] $groups
 * @property City $city
 * @property User $user
 */
class Volunteer extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_volunteer';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('id, id_city', 'required'),
            array('id, old, id_city', 'numerical', 'integerOnly' => true),
            array('other', 'length', 'max' => 50),
            array('utility', 'length', 'max' => 200),
            array('site', 'length', 'max' => 20),
            array('id, other, old, utility, site, id_city', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'groups' => array(self::HAS_MANY, VolunteerGroupUser::class, array('volunteer_id' => 'id')),
            'city' => array(self::BELONGS_TO, City::class, array('id_city' => 'id')),
            'user' => array(self::BELONGS_TO, User::class, 'id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'other' => 'Другое',
            'old' => 'Возраст',
            'utility' => 'utility',
            'site' => 'Социальная сеть',
            'id_city' => 'Город',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array('groups');
        $criteria->compare('id', $this->id);
        $criteria->compare('other', $this->other, true);
        $criteria->compare('old', $this->old);
        $criteria->compare('utility', $this->utility, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('id_city', $this->id_city);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Volunteer
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
