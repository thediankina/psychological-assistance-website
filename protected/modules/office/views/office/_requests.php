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
                return $this->createUrl('/request/view/' . $model->id);
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
));
