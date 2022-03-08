<?php
/**
 * Просмотр профиля специалиста или анкеты волонтера
 * @var $this UserController
 * @var $model User
 */

$this->pageTitle = 'Редактирование профиля';

if (Yii::app()->user->hasFlash('changeProfile')): ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('changeProfile'); ?>
    </div>
<?php endif; ?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form',
    'enableAjaxValidation' => false,
)); ?>

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH); ?>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить',
        array('submit' => array('user/save', 'id' => $model->id), 'class' => 'primary-button')); ?>
</menu>

<table class="detail-view">
    <tbody>
        <tr>
            <th>
                <?= $form->label($model, 'activity'); ?>
            </th>
            <td>
                <?= $form->dropDownList($model, 'activity', array(1 => 'Активен', 0 => 'Отключен'), array('class' => 'profile-form-field')); ?>
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
                <?= $form->label($model, 'id_group'); ?>
            </th>
            <td>
                <?= $form->dropDownList($model, 'id_group',
                    CHtml::listData(VolunteerGroup::model()->findAll(), 'id', 'group_name'), array(
                        'options' => array($model->volunteer->id_group => array('selected' => true)),
                        'class' => 'profile-form-field'
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
                        'class' => 'profile-form-field'
                    )); ?>
            </td>
        </tr>
    </tbody>
</table>

<?php $this->endWidget(); ?>
