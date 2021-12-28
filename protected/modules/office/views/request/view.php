<?php
/**
 * @var $this RequestController
 * @var $model Request
 */

use application\modules\office\models\Request;

$this->pageTitle = 'Просмотр заявки #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?php echo CHtml::htmlButton('Вернуться', array('submit' => array('/office/request'), 'class' => 'back-button')); ?>
    <?php echo CHtml::htmlButton('Принять', array('submit' => array('/office/agree'), 'class' => 'agree-button')); ?>
</menu>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'city.name',
        'category.category_name',
        'category.priority',
        'email',
        'phone',
        'body'
    ),
)); ?>
