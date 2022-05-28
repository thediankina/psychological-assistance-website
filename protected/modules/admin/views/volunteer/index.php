<?php
/**
 * @var $this VolunteerController
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\admin\controllers\VolunteerController;

$this->pageTitle = 'Список волонтеров';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php if (Yii::app()->user->hasFlash('changeProfile')): ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('changeProfile'); ?>
    </div>
<?php endif; ?>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array('/admin'), 'class' => 'back-button')); ?>
</menu>

<?php $this->widget('zii.widgets.grid.CGridView', array(
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
            'header' => 'Телефон',
            'name' => function ($model) {
                return $model->phone ?: null;
            }
        ),
        'mail:email',
        array(
            'header' => 'Статус',
            'name' => function ($model) {
                return $model->isActive == User::STATUS_ENABLED ? 'Активен' : 'Отключен';
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => function($model) {
                return $this->createUrl('/admin/volunteer', array('id' => $model->id));
            }
        ),
    ),
)); ?>
