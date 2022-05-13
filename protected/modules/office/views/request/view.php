<?php
/**
 * @var $this RequestController
 * @var $model Request
 * @var $history RequestHistory
 * @var $comments RequestHistory
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
    <?php if ($model->status == Request::STATUS_PLANNED): ?>
        <?= CHtml::htmlButton('Принять',
            array('submit' => array('request/accept', 'id' => $model->id), 'class' => 'primary-button')); ?>
    <?php else: ?>
        <?php if ($history && $history->comment == RequestHistory::ACTION_ACCEPTED): ?>
            <?= CHtml::htmlButton('Отклонить',
                array('submit' => array('request/reject', 'id' => $model->id), 'class' => 'primary-button')); ?>
            <?= CHtml::htmlButton('Завершить',
                array('submit' => array('request/finish', 'id' => $model->id), 'class' => 'primary-button')); ?>
        <?php endif; ?>
    <?php endif; ?>
</menu>

<div id="request">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'status',
            array(
                'label' => 'Исполнитель',
                'type' => 'html',
                'name' => 'executor.user.lastName',
                'value' => function ($model) {
                    return $model->status == Request::STATUS_IN_WORK | $model->status == Request::STATUS_REJECTED ? CHtml::link($model->executor->user->lastName,
                        $this->createUrl('/user/profile', array('id' => $model->executor->user->id))) : null;
                }
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
</div>

<div id="request-comments">
    <div id="request-comments-grid">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $comments->search(),
            'enablePagination' => false,
            'summaryText' => false,
            'columns' => array(
                'dateOfComment',
                'user.lastName',
                'comment',
            ),
        )); ?>
    </div>
    <div id="request-comments-create">
        <?php $comment = new RequestHistory();
        $form = $this->beginWidget(CActiveForm::class, array(
            'id' => 'request-comment-from',
            'enableAjaxValidation' => true,
        )); ?>

        <div id="request-comment">
            <?= $form->textField($comment, 'comment', array('class' => 'request-comment-field')); ?>
        </div>

        <div>
            <?= CHtml::submitButton('Отправить', array('class' => 'primary-button submit-button')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
