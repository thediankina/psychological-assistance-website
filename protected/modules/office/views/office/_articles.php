<?php
/**
 * @var $this OfficeController
 * @var $model Article
 */

use application\modules\office\controllers\OfficeController;
use application\modules\office\models\Article;
?>

<?= CHtml::htmlButton('Добавить', array('submit' => array('article/create'), 'class' => 'primary-button')); ?>

<?php $dataProvider = $model->search();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => false,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function ($model) {
                return CHtml::link($model->title, $this->createUrl('/article/view', array('id' => $model->id)));
            }
        ),
        'category.category_name',
        'status.status',
        array(
            'name' => 'dates_temp',
        ),
        array(
            'header' => 'Автор',
            'name' => 'author.lastName',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonUrl' => function ($model) {
                return $this->createUrl('/article/edit', array('id' => $model->id));
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
));
