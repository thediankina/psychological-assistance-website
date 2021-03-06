<?php
/**
 * @var $this ArticleController
 * @var $model Article
 */

use application\modules\office\models\ArticleTag;
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

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/office'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Черновик', array('submit' => array('article/draft', 'id' => $model->id ?: 0), 'class' => 'primary-button')); ?>
    <?= CHtml::htmlButton('Отправить', array('submit' => array('article/send', 'id' => $model->id ?: 0), 'class' => 'primary-button')); ?>
</menu>

<?php if (isset($model->moderations)): ?>
<div id="article-admin-comment">
    <?= $model->moderations->date; ?><br>
    Комментарий от администратора:<br><?= $model->moderations->comment; ?>
</div>
<?php endif; ?>

<div class="article-tags">
    <?= CHtml::activeCheckBoxList($model, 'chosenTags', ArticleTag::getAllTags()); ?>
</div>

<?= CHtml::activeDropDownList($model, 'type', $model->types, array('class' => 'article-field')); ?>

<?= CHtml::activedropDownList($model, 'id_category_article',
    CHtml::listData(Category::getCategories(), 'id', 'Parent'),
    array(
        'class' => 'article-field',
        'options' => Category::getAllParentsOptions(),
    )); ?>

<?= CHtml::activeTextField($model, 'title', array('class' => 'article-field')); ?>

<?php $this->widget('CKEditorWidget', array(
    'model' => $model,
    'attribute' => 'content',
    'config' => array(
        'language' => 'ru',
    ),
)); ?>

<?= CHtml::endForm(); ?>
