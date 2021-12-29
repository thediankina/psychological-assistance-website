<?php
/**
 * @var $this RequestController
 * @var $model Request
 */

use application\modules\office\controllers\RequestController;
use application\modules\office\models\Request;

$this->pageTitle = 'Просмотр заявки #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH); ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <?php if ($back_url === $this->home_url): ?>
    <?= CHtml::htmlButton('Принять', array('submit' => array('request/accept'), 'class' => 'primary-button')); ?>
    <?php else: ?>
    <?= CHtml::htmlButton('Отклонить', array('submit' => array('request/reject'), 'class' => 'primary-button')); ?>
    <?= CHtml::htmlButton('Завершить', array('submit' => array('request/finish'), 'class' => 'primary-button')); ?>
    <?php endif; ?>
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
