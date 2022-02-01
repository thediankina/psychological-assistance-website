<?php
/**
 * @var $this ForumController
 * @var $model Forum
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\forum\controllers\ForumController;
use application\modules\forum\models\Forum;

$this->pageTitle = 'Форум';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => false,
    'columns' => array(
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function ($model) {
                return CHtml::link($model->title, $this->createUrl('/forum/view', array('id' => $model->id)));
            }
        ),
        'description',
    ),
)); ?>
