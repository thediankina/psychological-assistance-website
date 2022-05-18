<?php
/**
 * @var $this OfficeController
 * @var $data Request
 */

use application\modules\office\controllers\OfficeController;
use application\modules\office\models\Request;

$dataProvider = $data->search();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => false,
    'columns' => array(
        'id',
        'category.category_name',
        'category.priority',
        'status',
        array(
            'header' => 'Исполнитель',
            'name' => 'executor.user.lastName',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => function($model) {
                return $this->createUrl('/request/view', array('id' => $model->id));
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
));
