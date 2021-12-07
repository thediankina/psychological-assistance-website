<?php
/**
 * @var $this OfficeController
 * @var $dataProvider CActiveDataProvider
 */
$this->pageTitle = 'Личный кабинет';
?>

<h1 class="title"><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => false,
    'summaryText' => 'Всего найдено ' . $dataProvider->itemCount . ' записей',
    'columns' => array(
        'city_name.name',
        array(
            'name' => 'category.category_name',
            'value' => function ($model) {
                return $model->category->category_name;
            }
        ),
        'category.priority',
        'status',
        'subject',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
)); ?>
