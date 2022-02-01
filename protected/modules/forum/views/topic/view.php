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

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH) . "?id=" . $model->id_forum; ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
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