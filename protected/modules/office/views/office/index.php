<?php
/**
 * @var $this OfficeController
 * @var $Request CActiveDataProvider
 * @var $Article CActiveDataProvider
 */
// Можно заменить на CTabView Widget
use application\modules\office\controllers\OfficeController;

$this->pageTitle = 'Личный кабинет';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<div class="tabs">
    <input type="radio" name="tab-button" id="tab-button-requests" value="" checked>
    <label for="tab-button-requests">Заявки, над которыми я работаю</label>
    <input type="radio" name="tab-button" id="tab-button-articles" value="">
    <label for="tab-button-articles">Мои статьи</label>

    <div id="requests"><?php $this->renderPartial('request/index', array('dataProvider' => $Request)); ?></div>
    <div id="articles"><?php $this->renderPartial('article/index', array('dataProvider' => $Article)); ?></div>
</div>
