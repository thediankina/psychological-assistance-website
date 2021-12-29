<?php
/**
 * @var $this OfficeController
 * @var $dataProvider CActiveDataProvider
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $dataProvider->itemCount,
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
