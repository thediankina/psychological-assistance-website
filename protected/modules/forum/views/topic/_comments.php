<?php
/**
 * @var $comments Comment[]
 */

use application\modules\forum\models\Comment;

if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php foreach($comments as $comment): ?>
<div class="comment" id="c<?= $comment->id; ?>">

    <div class="comment-author">
        <?= CHtml::link(implode('&nbsp;',
            array($comment->author->lastName, $comment->author->firstName, $comment->author->middleName)),
            $this->createUrl('/user/profile', array('id' => $comment->author->id))); ?>
    </div>

    <div class="comment-position">
        <?= implode(', ', array($comment->author->position->namePosition, $comment->author->city->name)); ?>
    </div>

    <div class="comment-time">
        <?= $comment->public_date; ?>
    </div>

    <div class="comment-content">
        <?= CHtml::encode($comment->content); ?>
    </div>

</div><!-- comment -->
<?php endforeach; ?>
