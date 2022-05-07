<?php
/**
 * Просмотр/редактирование профиля специалиста/волонтера
 * @var $this UserController
 * @var $model User
 */

if ($model->id == Yii::app()->user->id) {
    $this->pageTitle = 'Редактирование профиля';
} else {
    $this->pageTitle = 'Просмотр профиля #' . $model->id;
}

if (Yii::app()->user->hasFlash('changeProfile')): ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('changeProfile'); ?>
    </div>
<?php endif; ?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php if ($model->id == Yii::app()->user->id) {
    $this->renderPartial('_edit', array('model' => $model));
} else {
    $this->renderPartial('_view', array('model' => $model));
}
?>
