<?php
/**
 * @var $this AuthController
 * @var $model LoginForm
 * @var $form CActiveForm
 */

use application\modules\office\controllers\AuthController;

$this->pageTitle = 'Вход';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <div class="row">
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div class="clear"></div>

    <div class="row">
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->hiddenField($model, 'rememberMe'); ?>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>

    <menu>
        <?php echo CHtml::submitButton('Войти', array('class' => 'primary-button submit-button')); ?>
    </menu>

    <?php $this->endWidget(); ?>
</div><!-- form -->
