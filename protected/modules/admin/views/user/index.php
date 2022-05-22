<?php
/**
 * @var $this UserController
 * @var $model User
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\admin\controllers\UserController;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');

$this->pageTitle = 'Запросы на регистрацию';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/admin'), 'class' => 'back-button')); ?>
    <?= CHtml::ajaxSubmitButton('Удалить выбранные', $this->createUrl('user/remove'),
        array(
            'data' => 'js:{ids:getSelectedIds("users-grid")}',
            'success' => 'js:updateGrid("users-grid")'
        ),
        array('class' => 'ajax-submit-button')); ?>
</menu>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'users-grid',
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $dataProvider->itemCount,
    'columns' => array(
        'id',
        array(
            'header' => 'ФИО',
            'name' => function ($model) {
                return  $model->lastName . ' ' . $model->firstName . ' ' . $model->middleName;
            },
        ),
        'city.name',
        array(
            'header' => 'Контактные данные',
            'name' => function($model) {
                if (isset($model->phone) && isset($model->mail)) {
                    return nl2br($model->phone . ' | ' . $model->mail);
                } elseif (isset($model->phone)) {
                    return $model->phone;
                } elseif (isset($model->mail)) {
                    return $model->mail;
                }
                return null;
            },
        ),
        'position.namePosition',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => function($model) {
                return $this->createUrl('user/request', array('id' => $model->id));
            }
        ),
        array(
            'class' => 'CCheckBoxColumn',
            'id' => 'selectedIds',
            'selectableRows' => '20',
        ),
    ),
)); ?>
