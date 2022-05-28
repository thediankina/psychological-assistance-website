<?php
/**
 * Просмотр профиля
 * @var $model User
 * @todo Поменять кнопку "Вернуться" (попробовать открыть профиль в новом окне)
 */
?>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/volunteers'), 'class' => 'back-button')); ?>
</menu>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'isActive',
            'value' => function ($model) {
                return $model->isActive == User::STATUS_ENABLED ? 'Активен' : 'Отключен';
            }
        ),
        array(
            'name' => 'lastName',
            'value' => function ($model) {
                return $model->lastName ?: null;
            }
        ),
        array(
            'name' => 'firstName',
            'value' => function ($model) {
                return $model->firstName ?: null;
            }
        ),
        array(
            'name' => 'middleName',
            'value' => function ($model) {
                return $model->middleName ?: null;
            }
        ),
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
        array(
            'name' => 'phone',
            'value' => function ($model) {
                return $model->phone ?: null;
            }
        ),
        'mail:email',
        array(
            'name' => 'old',
            'value' => function ($model) {
                return $model->isVolunteer() ? Volunteer::model()->findByPk($model->id)->old : null;
            }
        ),
        array(
            'name' => 'site',
            'value' => function ($model) {
                 if ($model->isVolunteer() && Volunteer::model()->findByPk($model->id)->site) {
                     return Volunteer::model()->findByPk($model->id)->site;
                 } else {
                     return null;
                 }
            }
        ),
        array(
            'name' => 'groupIds',
            'type' => 'raw',
            'value' => function ($model) {
                return $model->getVolunteerGroups() ? nl2br($model->getVolunteerGroups()) : null;
            }
        ),
        array(
            'name' => 'other',
            'value' => function ($model) {
                if ($model->isVolunteer() && Volunteer::model()->findByPk($model->id)->other) {
                    return Volunteer::model()->findByPk($model->id)->other;
                } else {
                    return null;
                }
            }
        ),
        array(
            'name' => 'utility',
            'value' => function ($model) {
                if ($model->isVolunteer() && Volunteer::model()->findByPk($model->id)->utility) {
                    return Volunteer::model()->findByPk($model->id)->utility;
                } else {
                    return null;
                }
            }
        ),
    ),
));
