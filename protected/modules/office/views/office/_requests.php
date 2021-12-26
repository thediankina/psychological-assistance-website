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
        'city.name',
        array(
            'name' => 'category.category_name',
            'value' => function ($model) {
                return $model->category->category_name;
            }
        ),
        'category.priority',
        'status',
        array(
            'name' => 'id_user',
            'value' => function ($model) {
                return $model->user->username;
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => function($model) {
                return $this->createUrl('/office/request/view', array('id' => $model->id));
            }
        ),
    ),
    'pager' => array('class' => 'OfficePager', 'header' => ''),
));
