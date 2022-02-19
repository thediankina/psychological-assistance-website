<?php
/**
 * @var $this Controller
 * @var $content
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');
?>

<?php $this->beginContent('//layouts/main'); ?>
    <div id="overlay" style="display: none" onclick="openMenu()"></div>
    <div id="sidebar" style="display: none">
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label'=>'Все заявки', 'url'=>array('/requests')),
                array('label'=>'Личный кабинет', 'url'=>array('/office')),
                array('label'=>'Форум', 'url'=>array('/forum')),
                array('label'=>'Волонтеры', 'url'=>array('/volunteers')),
                array('label'=>'Мой профиль', 'url'=>array('/user/profile', 'id'=>Yii::app()->user->id)),
            ),
        )); ?>
    </div><!-- sidebar -->
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>
