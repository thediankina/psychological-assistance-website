<?php
/**
 * Просмотр статьи для неавторизированного пользователя
 * @var $this ArticleController
 * @var $model Article
 */

use application\modules\office\models\Article;

$this->pageTitle = 'Просмотр статьи #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<div id="article-title"><?= $model->title; ?></div>
<div id="article-content"><?= $model->content; ?></div>
<div id="article-date"><?= nl2br($model->author->firstName . ' ' . $model->author->lastName . ' ' . $model->dates_temp); ?></div>
