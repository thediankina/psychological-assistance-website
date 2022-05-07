<?php
/**
 * Просмотр профиля
 * @var $model User
 */

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'isActive',
            'value' => function ($model) {
                return $model->isActive == User::STATUS_ENABLED ? 'Активен' : 'Отключен';
            }
        ),
        'lastName',
        'firstName',
        'middleName',
        array(
            'name' => 'id_position',
            'value' => function ($model) {
                return Position::model()->findByPk($model->id_position)->namePosition;
            }
        ),
        array(
            'name' => 'id_city',
            'value' => function ($model) {
                return City::model()->findByPk($model->id_city)->name;
            }
        ),
        'phone',
        'mail',
        array(
            'name' => 'old',
            'value' => function ($model) {
                return $model->isVolunteer() ? Volunteer::model()->findByPk($model->id)->old : null;
            }
        ),
        array(
            'name' => 'site',
            'value' => function ($model) {
                return $model->isVolunteer() ? Volunteer::model()->findByPk($model->id)->site : null;
            }
        ),
        array(
            'name' => 'id_group',
            'value' => function ($model) {
                return $model->isVolunteer() ? VolunteerGroup::model()->findByPk($model->volunteer->id_group)->group_name : null;
            }
        ),
        array(
            'name' => 'utility',
            'value' => function ($model) {
                return $model->isVolunteer() ? Volunteer::model()->findByPk($model->id)->utility : null;
            }
        ),
    ),
));
