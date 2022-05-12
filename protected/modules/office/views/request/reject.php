<?php
/**
 * @var $this RequestController
 * @var $request Request
 * @var $history RequestHistory
 * @var $form CActiveForm
 */

use application\modules\office\models\Request;
use application\modules\office\models\RequestHistory;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'reject-form',
    'enableAjaxValidation' => false,
));

$this->pageTitle = 'Отклонить заявку #' . $request->id;

if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/office'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить',array('type' => 'submit', 'class' => 'primary-button')); ?>
</menu>

<div class="form">

    <p class="note">Укажите причину, по которой Вам пришлось отклонить заявку</p>

    <div class="row">
        <?php echo $form->textArea($history, 'comment', array('rows' => 15, 'cols' => 100)); ?>
    </div>

</div>
<?php $this->endWidget(); ?>
