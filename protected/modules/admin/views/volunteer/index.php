<?php
/**
 * @var $this VolunteerController
 * @var $model User
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\admin\controllers\VolunteerController;

$this->pageTitle = 'Список волонтеров';
?>

<h1><?php echo $this->pageTitle; ?></h1>

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
            'header' => 'Имя',
            'name' => function ($model) {
                return  $model->firstName;
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
            'header' => 'Волонтерская группа',
            'name' => function ($model) {
                return VolunteerGroup::model()->findByPk($model->volunteer->id_group)->group_name;
            }
        ),
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
                return $this->createUrl('/user/profile', array('id' => $model->id));
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'viewButtonUrl' => function($model) {
                return $this->createUrl('/user/delete', array('id' => $model->id));
            }
        ),
    ),
)); ?>
