<?php
/**
 * @var $this OfficeController
 * @var $data CActiveDataProvider
 */

use application\modules\office\controllers\OfficeController;

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $data,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $data->itemCount,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function($row) {
                return CHtml::link($row->title, array('/article/view/' . $row->id));
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
