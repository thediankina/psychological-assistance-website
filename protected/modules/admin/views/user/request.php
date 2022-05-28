<?php
/**
 * Просмотр запроса на регистрацию
 * @var $this UserController
 * @var $model User
 */

$this->pageTitle = 'Просмотр запроса на регистрацию #' . $model->id;
?>

<h1><?= $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться',
        array('submit' => array('/admin/users'), 'class' => 'back-button')); ?>
    <?= CHtml::ajaxSubmitButton('Удалить', $this->createUrl('remove'),
        array(
            'data' => 'js:{ids:'. $model->id .'}',
            'success' => 'js:window.location.href = "/admin/users"'
        ),
        array('class' => 'ajax-submit-button')); ?>
    <?= CHtml::htmlButton('Принять',
        array('submit' => array('approve', 'id' => $model->id), 'class' => 'primary-button')); ?>
</menu>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
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
                return $model->isVolunteer() ? Volunteer::model()->findByPk($model->id)->other : null;
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
