<?php
/**
 * @var $this ArticleController
 * @var $model Article
 */

use application\modules\office\models\Category;
use application\modules\office\controllers\ArticleController;
use application\modules\office\models\Article;

Yii::import('ext.yii-ckeditor.CKEditorWidget');

$this->pageTitle = ($model->id) ? 'Редактирование статьи #' . $model->id : 'Создание статьи';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?= CHtml::beginForm(); ?>

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH); ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <?= ($model->id) ? CHtml::htmlButton('Сохранить', array('type' => 'submit', 'class' => 'primary-button')) : ''; ?>
    <?= CHtml::htmlButton('Отправить', array('type' => 'submit', 'class' => 'primary-button')); ?>
</menu>

<?= CHtml::activedropDownList($model, 'id_category_article',
    CHtml::listData(Category::model()->findAll(), 'id', 'category_name'), array('class' => 'article-field')); ?>

<?= CHtml::activeTelField($model, 'title', array('class' => 'article-field')); ?>

<?php $this->widget('CKEditorWidget', array(
    'model' => $model,
    'attribute' => 'content',
    'config' => array(
        'language' => 'ru',
    ),
)); ?>

<?= CHtml::endForm(); ?>
