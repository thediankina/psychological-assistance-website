<?php
/**
 * @var $this ForumController
 * @var $model Forum
 */

use application\modules\admin\controllers\ForumController;
use application\modules\forum\models\Forum;

$this->pageTitle = ($model->id) ? 'Редактирование раздела #' . $model->id : 'Создание раздела';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?= CHtml::beginForm(); ?>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/admin/forums'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить', array('type' => 'submit', 'class' => 'primary-button')); ?>
</menu>

<?= CHtml::activeTextField($model, 'title', array('class' => 'article-field')); ?>

<?= CHtml::activeTextField($model, 'description', array('class' => 'article-field')); ?>

<?= CHtml::endForm(); ?>
