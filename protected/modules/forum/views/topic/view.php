<?php
/**
 * @var $this TopicController
 * @var $model Topic
 * @var $comment Comment
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\forum\controllers\TopicController;
use application\modules\forum\models\Comment;
use application\modules\forum\models\Topic;

$this->pageTitle = $model->title;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array("/forum/view?id=" . $model->id_forum), 'class' => 'back-button')); ?>
</menu>

<div id="comments">
    <?php $this->renderPartial('_comments', array(
        'post' => $model,
        'comments' => $model->comments,
    )); ?>

    <?php $this->renderPartial('../comment/_form', array(
        'model' => $comment,
        'topic' => $model,
    )); ?>
</div>