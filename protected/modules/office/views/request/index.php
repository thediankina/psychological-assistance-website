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
            'type' => 'html',
            'name' => 'executor.user.lastName',
            'value' => function ($model) {
                return $model->status == Request::STATUS_IN_WORK | $model->status == Request::STATUS_REJECTED ? CHtml::link($model->executor->user->lastName,
                    $this->createUrl('/user/profile', array('id' => $model->executor->user->id))) : null;
            }
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
