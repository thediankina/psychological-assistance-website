<?php
/**
 * @var $this OfficeController
 * @var $dataProvider CActiveDataProvider
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => false,
    'summaryText' => 'Всего найдено ' . $dataProvider->itemCount . ' записей',
    'columns' => array(
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
            'name' => 'Назначено',
            'value' => function ($model) {
                return $model->user->username;
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
    'pager' => array('class' => 'OfficePager', 'header' => ''),
));
