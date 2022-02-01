<?php
/**
 * @var $this ForumController
 * @var $model Topic
 * @var $forum Forum
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\forum\controllers\ForumController;
use application\modules\forum\models\Forum;
use application\modules\forum\models\Topic;

$this->pageTitle = $forum->title;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $back_url = $this->home_url; ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
</menu>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => false,
    'columns' => array(
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function ($model) {
                return CHtml::link($model->title, $this->createUrl('topic/view', array('id' => $model->id)));
            }
        ),
        array(
            'header' => 'Автор',
            'name' => 'id_author',
            'value' => function ($model) {
                return $model->author->lastName;
            }
        ),
        'public_date',
    ),
)); ?>
