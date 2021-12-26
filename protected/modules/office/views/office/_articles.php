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
        'title',
        'dates_temp',
        'status',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
    'pager' => array('class' => 'OfficePager', 'header' => ''),
));
