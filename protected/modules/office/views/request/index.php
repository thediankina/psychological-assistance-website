<?php
/**
 * @var $this RequestController
 * @var $model Request
 * @var $dataProvider CActiveDataProvider
 */

$this->pageTitle = 'Все заявки';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено ' . $dataProvider->itemCount . ' записей',
    'columns' => array(
        array('name' => 'id'),
        array('name' => 'city.name'),
        array(
            'name' => 'category.category_name',
            'value' => function ($model) {
                return $model->category->category_name;
            }
        ),
        array('name' => 'category.priority'),
        array('name' => 'status'),
        array(
            'name' => 'id_user',
            'value' => function ($model) {
                return isset($model->user->username) ? $model->user->username : '';
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
    'pager' => array('class' => 'OfficePager', 'header' => ''),
)); ?>
