<?php

/**
 * This is the model class for table "db_request".
 *
 * The followings are the available columns in table 'db_request':
 * @property integer $id
 * @property string $name
 * @property integer $id_category
 * @property string $body
 * @property integer $id_city
 * @property string $email
 * @property integer $phone
 * @property string $comment
 * @property string $status
 * @property integer $id_user
 */
class Request extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'db_request';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, id_category, body, id_city, status', 'required'),
            array('id_category, phone, id_user', 'numerical', 'integerOnly' => true),
            array('email, status', 'length', 'max' => 20),
            array('comment', 'length', 'max' => 100),
            array('id, name, id_category, body, id_city, email, phone, comment, status, id_user', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'category' => array(self::HAS_ONE, 'CategoryRequest', array('id' => 'id_category')),
            'city' => array(self::HAS_ONE, 'City', array('id' => 'id_city')),
            'user' => array(self::HAS_ONE, 'User', array('id' => 'id_user'))
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Имя/Псевдоним',
            'id_category' => 'ID категории',
            'body' => 'Описание',
            'id_city' => 'ID города',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'id_user' => 'Назначено',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('category', 'city', 'user');
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name);
        $criteria->compare('category.id', $this->id_category);
        $criteria->compare('city.id', $this->id_city);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('user.id', $this->id_user, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
            'sort' => array(
                'attributes' => array(
                    'id',
                    'city.name',
                    'category.category_name',
                    'category.priority',
                    'status',
                    'user.username'
                )
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Request the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
