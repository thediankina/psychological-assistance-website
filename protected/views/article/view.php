<?php
/**
 * Просмотр статьи для неавторизированного пользователя
 * @var $this ArticleController
 * @var $model Article
 * @var $tags array
 */

use application\modules\office\models\Article;
use application\modules\office\models\ArticleTag;

$this->pageTitle = 'Просмотр статьи #' . $model->id;
?>

<h1><?= $this->pageTitle; ?></h1>

<div class="article-tags">
    <?php foreach ($tags as $tag): ?>
        <div class="article-tag"><?= ArticleTag::getTagName($tag); ?></div>
    <?php endforeach; ?>
</div>
<div id="article-title"><?= $model->title; ?></div>
<div id="article-content"><?= $model->content; ?></div>
<div id="article-date"><?= nl2br($model->author->firstName . ' ' . $model->author->lastName . ' ' . $model->dates_temp); ?></div>
