<?php
/**
 * @var $this ModerationController
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\admin\controllers\ModerationController;

$this->pageTitle = 'Панель администратора';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => false,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => function ($row) {
                return CHtml::link($row['name'], $this->createUrl($row['link']));
            }
        ),
        'description',
    ),
)); ?>
