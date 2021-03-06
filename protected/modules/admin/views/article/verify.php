<?php
/**
 * @var $this ArticleController
 * @var $model Article
 * @var $tags array
 */

use application\modules\admin\controllers\ArticleController;
use application\modules\office\models\Article;
use application\modules\office\models\ArticleTag;

$this->pageTitle = 'Обзор статьи #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/admin/articles'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Вернуть автору', array('submit' => array('article/return', 'id' => $model->id), 'class' => 'primary-button')); ?>
    <?= CHtml::htmlButton('Опубликовать', array('submit' => array('article/accept', 'id' => $model->id), 'class' => 'primary-button')); ?>
</menu>

<div class="article-tags">
    <?php foreach ($tags as $tag): ?>
        <div class="article-tag"><?= ArticleTag::getTagName($tag); ?></div>
    <?php endforeach; ?>
</div>

<div id="article-title"><?= $model->title; ?></div>
<div id="article-content"><?= $model->content; ?></div>
<div id="article-date"><?= nl2br($model->author->firstName . ' ' . $model->author->lastName . ' ' . $model->dates_temp); ?></div>
