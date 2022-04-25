<?php
/**
 * @var $this RequestController
 * @var $model Request
 * @var $history RequestHistory
 */

use application\modules\office\controllers\RequestController;
use application\modules\office\models\Request;
use application\modules\office\models\RequestHistory;

$this->pageTitle = 'Просмотр заявки #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $back_url = parse_url(Yii::app()->request->urlReferrer, PHP_URL_PATH); ?>
<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <?php if (empty($model->executor->user->id)): ?>
        <?= CHtml::htmlButton('Принять',
            array('submit' => array('request/accept', 'id' => $model->id), 'class' => 'primary-button')); ?>
    <?php else: ?>
        <?php if ($history && $history->comment == "Принято"): ?>
            <?= CHtml::htmlButton('Отклонить',
                array('submit' => array('request/reject', 'id' => $model->id), 'class' => 'primary-button')); ?>
            <?= CHtml::htmlButton('Завершить',
                array('submit' => array('request/finish', 'id' => $model->id), 'class' => 'primary-button')); ?>
        <?php endif; ?>
    <?php endif; ?>
</menu>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'status',
        array(
            'label' => 'Исполнитель',
            'name' => 'executor.user.lastName',
        ),
        'name',
        'city.name',
        'old',
        'category.category_name',
        'category.priority',
        'email',
        'phone',
        array(
            'name' => 'info',
            'value' => function ($model) {
                return wordwrap($model->info, 200, "\n", 1);
            }
        ),
    ),
)); ?>
