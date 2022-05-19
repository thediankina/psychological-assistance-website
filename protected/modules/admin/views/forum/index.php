<?php
/**
 * @var $this ForumController
 * @var $model Forum
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\admin\controllers\ForumController;
use application\modules\forum\models\Forum;

$this->pageTitle = 'Редактирование форума';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/admin'), 'class' => 'back-button')); ?>
    <?= CHtml::htmlButton('Добавить', array('submit' => array('forum/create'), 'class' => 'primary-button')); ?>
</menu>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $dataProvider->itemCount,
    'columns' => array(
        'id',
        'title',
        'description',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonUrl' => function($model) {
                return $this->createUrl('/forum/edit', array('id' => $model->id));
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
)); ?>
