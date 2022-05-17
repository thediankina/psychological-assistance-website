<?php
/**
 * @var $this ModerationController
 * @var $categories array
 */

use application\modules\admin\controllers\ModerationController;

$this->pageTitle = 'Панель администратора';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<div class="forums">
    <?php foreach ($categories as $category): ?>
        <a class="forum" href="<?= $category['link']; ?>">
            <div class="forum-title"><?= $category['name']; ?></div>
            <div class="forum-description"><?= $category['description']; ?></div>
        </a>
    <?php endforeach; ?>
</div>

