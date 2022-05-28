<?php
/**
 * Редактирование профиля волонтера
 * @var $this VolunteerController
 * @var $model User
 */

use application\modules\admin\controllers\VolunteerController;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');

if ($model->id == Yii::app()->user->id) {
    $this->pageTitle = 'Редактирование профиля волонтера';
} else {
    $this->pageTitle = 'Просмотр профиля волонтера #' . $model->id;
} ?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php if (Yii::app()->user->hasFlash('changeProfile')): ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('changeProfile'); ?>
    </div>
<?php endif; ?>

<menu>
    <?= CHtml::htmlButton('Вернуться',
        array('submit' => array('/admin/volunteers'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить',
        array('submit' => array('volunteer/save', 'id' => $model->id), 'class' => 'primary-button')); ?>
</menu>

<?php $form = $this->beginWidget(CActiveForm::class, array(
    'id' => 'profile-form',
    'enableAjaxValidation' => false,
)); ?>

<table class="detail-view">
    <tbody>
    <tr>
        <th>
            <?= $form->label($model, 'isActive'); ?>
        </th>
        <td>
            <?= $form->dropDownList($model, 'isActive', array(1 => 'Активен', 0 => 'Отключен'),
                array('class' => 'profile-form-field')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'lastName'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'lastName',
                array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'firstName'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'firstName',
                array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'middleName'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'middleName',
                array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'id_position'); ?>
        </th>
        <td>
            <?= $form->dropDownList($model, 'id_position',
                CHtml::listData(Position::model()->findAll(), 'id', 'namePosition'),
                array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'id_city'); ?>
        </th>
        <td>
            <?= $form->dropDownList($model, 'id_city', CHtml::listData(City::model()->findAll(), 'id', 'name'),
                array('class' => 'profile-form-field')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'phone'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'phone', array('class' => 'profile-form-field')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'mail'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'mail', array('class' => 'profile-form-field')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'site'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'site', array(
                'value' => Volunteer::model()->findByPk($model->id) ? (Volunteer::model()->findByPk($model->id))->site : '',
                'disabled' => !(($model->id_position == User::VOLUNTEER_POSITION)),
                'class' => 'profile-form-field',
            )); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'old'); ?>
        </th>
        <td>
            <?= $form->numberField($model, 'old', array(
                'value' => Volunteer::model()->findByPk($model->id) ? (Volunteer::model()->findByPk($model->id))->old : '',
                'disabled' => !(($model->id_position == User::VOLUNTEER_POSITION)),
                'class' => 'profile-form-field',
            )); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'groupIds'); ?>
        </th>
        <td>
            <?= $form->checkBoxList($model, 'groupIds',
                CHtml::listData(VolunteerGroup::model()->findAll(), 'id', 'group_name'),
                array(
                    'disabled' => !(($model->id_position == User::VOLUNTEER_POSITION)),
                    'class' => 'profile-form-checkbox',
                )); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'other'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'other', array(
                'value' => Volunteer::model()->findByPk($model->id) ? (Volunteer::model()->findByPk($model->id))->other : '',
                'disabled' => !(in_array(6, $model->groupIds)),
                'class' => 'profile-form-field',
            )); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'utility'); ?>
        </th>
        <td>
            <?= $form->textArea($model, 'utility', array(
                'value' => Volunteer::model()->findByPk($model->id) ? (Volunteer::model()->findByPk($model->id))->utility : '',
                'disabled' => !(($model->id_position == User::VOLUNTEER_POSITION)),
                'class' => 'profile-form-field',
            )); ?>
        </td>
    </tr>
    </tbody>
</table>

<?php $this->endWidget(); ?>
