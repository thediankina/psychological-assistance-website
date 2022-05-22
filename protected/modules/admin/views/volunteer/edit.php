<?php
/**
 * Редактирование профиля волонтера
 * @var $model User
 */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form',
    'enableAjaxValidation' => false,
)); ?>

<menu>
    <?= CHtml::htmlButton('Вернуться',
        array('submit' => array('/admin/volunteers'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить',
        array('submit' => array('volunteer/save', 'id' => $model->id), 'class' => 'primary-button')); ?>
</menu>

<table class="detail-view">
    <tbody>
    <tr>
        <th>
            <?= $form->label($model, 'isActive'); ?>
        </th>
        <td>
            <?= $form->dropDownList($model, 'isActive', array(1 => 'Активен', 0 => 'Отключен'), array('class' => 'profile-form-field')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'lastName'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'lastName', array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'firstName'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'firstName', array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= $form->label($model, 'middleName'); ?>
        </th>
        <td>
            <?= $form->textField($model, 'middleName', array('class' => 'profile-form-field', 'disabled' => 'disabled')); ?>
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
            <?= $form->dropDownList($model, 'id_city', CHtml::listData(City::model()->findAll(), 'id', 'name'), array('class' => 'profile-form-field')); ?>
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
            <?= $form->label($model, 'id_group'); ?>
        </th>
        <td>
            <?= $form->dropDownList($model, 'id_group',
                CHtml::listData(VolunteerGroup::model()->findAll(), 'id', 'group_name'), array(
                    'options' => ($model->id_position == User::VOLUNTEER_POSITION) ? array($model->volunteer->id_group => array('selected' => true)) : '',
                    'disabled' => !(($model->id_position == User::VOLUNTEER_POSITION)),
                    'class' => 'profile-form-field',
                    'empty' => '',
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