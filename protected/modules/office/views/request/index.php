<?php
/**
 * @var $this RequestController
 * @var $model Request
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\office\controllers\RequestController;
use application\modules\office\models\Request;

$this->pageTitle = 'Все заявки';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $dataProvider->itemCount,
    'columns' => array(
        'id',
        'city.name',
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
)); ?>
