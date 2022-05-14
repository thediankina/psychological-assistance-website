<?php
/**
 * @var $this ForumController
 * @var $forums array
 */

use application\modules\forum\controllers\ForumController;

$this->pageTitle = 'Форум';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<div class="forums">
    <?php foreach ($forums as $forum): ?>
    <a class="forum" href="forum/view?id=<?= $forum['id']; ?>">
        <div class="forum-title"><?= $forum['title']; ?></div>
        <div class="forum-description"><?= $forum['description']; ?></div>
    </a>
    <?php endforeach; ?>
</div>
