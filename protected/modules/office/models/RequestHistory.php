<?php

namespace application\modules\office\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use User;

/**
 * Модель истории действий над заявкой
 *
 * Атрибуты
 * @property integer $id
 * @property integer $IDuser
 * @property integer $IDrequest
 * @property string $comment
 * @property string $dateOfComment
 *
 * Связи
 * @property Request $request
 * @property User $user
 */
class RequestHistory extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_user_request';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('IDuser, IDrequest, comment, dateOfComment', 'required'),
            array('IDuser, IDrequest', 'numerical', 'integerOnly' => true),
            array('comment', 'length', 'max' => 200),
            array('id, IDuser, IDrequest, comment, dateOfComment', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'request' => array(self::BELONGS_TO, Request::class, array('IDrequest' => 'id')),
            'user' => array(
                self::BELONGS_TO,
                User::class,
                array('IDuser' => 'id'),
                'select' => 'lastName',
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
            'IDuser' => 'Iduser',
            'IDrequest' => 'Idrequest',
            'comment' => 'Comment',
            'dateOfComment' => 'Date Of Comment',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('user');
        $criteria->compare('id', $this->id);
        $criteria->compare('IDuser', $this->IDuser);
        $criteria->compare('IDrequest', $this->IDrequest);
        $criteria->compare('comment',$this->comment,true);
        $criteria->compare('dateOfComment',$this->dateOfComment,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return RequestHistory
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
