<?php
/**
 * Форма создания комментария находится отдельно, т.к. у обсуждения своя форма
 * @var $model Comment
 * @var $topic Topic
 */

use application\modules\forum\models\Comment;
use application\modules\forum\models\Topic;

?>
<div class="form">

    <?php $form = $this->beginWidget(CActiveForm::class, array(
        'id' => 'comment-form',
        'enableAjaxValidation' => true,
    )); ?>

    <div class="comment-row">
        <?= $form->errorSummary($model); ?>
    </div>

    <div class="comment-row">
        <?= $form->hiddenField($model, 'id_topic', array('value' => $topic->id)); ?>
    </div>

    <div class="comment-row">
        <?= $form->hiddenField($model, 'public_date', array('value' => date('Y-m-d H:i:s'))); ?>
    </div>

    <div class="comment-row">
        <?= $form->hiddenField($model, 'id_author', array('value' => Yii::app()->user->id)); ?>
    </div>

    <div class="comment-row">
        <?= $form->textArea($model, 'content', array('rows' => 5)); ?>
    </div>

    <div class="comment-row comment-buttons">
        <?= CHtml::submitButton('Отправить', array('class' => 'primary-button submit-button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
