<?php
/**
 * Просмотр профиля специалиста или анкеты волонтера
 * @var $this UserController
 * @var $model User
 */

$this->pageTitle = 'Редактирование профиля';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH); ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить', array('submit' => array('user/save', 'id' => $model->id), 'class' => 'primary-button')); ?>
<menu>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'lastName',
        'firstName',
        'middleName',
        'position.namePosition',
        'city.name',
        'phone',
        'mail',
        'volunteer.utility',
    )
)); ?>
