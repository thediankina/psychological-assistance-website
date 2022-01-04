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
