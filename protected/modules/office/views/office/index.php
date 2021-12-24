<?php
/**
 * @var $this OfficeController
 * @var $dataProvider Request
 */

$this->pageTitle = 'Личный кабинет';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => false,
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
)); ?>
