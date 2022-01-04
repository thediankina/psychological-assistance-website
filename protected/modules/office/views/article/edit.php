<?php
/**
 * @var $this ArticleController
 * @var $model Article
 */

use application\modules\office\controllers\ArticleController;
use application\modules\office\models\Article;

Yii::import('ext.yii-ckeditor.CKEditorWidget');

$this->pageTitle = 'Редактирование статьи #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?= CHtml::beginForm(); ?>

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH); ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Сохранить', array('type' => 'submit', 'class' => 'primary-button')); ?>
</menu>

<?= CHtml::activeTelField($model, 'title', array('class' => 'article-title')); ?>

<?php $this->widget('CKEditorWidget', array(
    'model' => $model,
    'attribute' => 'content',
    'config' => array(
        'language' => 'ru',
    ),
)); ?>

<?= CHtml::endForm(); ?>
