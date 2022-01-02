<?php
/**
 * @var $this OfficeController
 * @var $data Article
 */

use application\modules\office\controllers\OfficeController;
use application\modules\office\models\Article;

$dataProvider = $data->search();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $dataProvider->itemCount,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function($model) {
                return CHtml::link($model->title, array('/article/view/' . $model->id));
            }
        ),
        array(
            'name' => 'dates_temp',
        ),
        'status',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonUrl' => function($model) {
                return $this->createUrl('/article/view/' . $model->id);
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
));
