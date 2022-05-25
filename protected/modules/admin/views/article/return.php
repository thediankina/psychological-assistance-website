<?php
/**
 * @var $this ArticleController
 * @var $article Article
 * @var $history Moderation
 * @var $form CActiveForm
 */

use application\modules\admin\controllers\ArticleController;
use application\modules\admin\models\Moderation;
use application\modules\office\models\Article;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'return-form',
    'enableAjaxValidation' => false,
));

$this->pageTitle = 'Вернуть автору статью #' . $article->id;

if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('article/verify', 'id' => $article->id), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить',array('type' => 'submit', 'class' => 'primary-button')); ?>
</menu>

<div class="form">

    <p class="note">Укажите причину, по которой Вам пришлось вернуть статью автору</p>

    <div class="row">
        <?php echo $form->textArea($history, 'comment', array('rows' => 15, 'cols' => 100)); ?>
    </div>

</div>
<?php $this->endWidget(); ?>
