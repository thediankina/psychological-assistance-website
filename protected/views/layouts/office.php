<?php
/**
 * @var $this Controller
 * @var $content
 * @todo Изменить условия видимости пунктов меню согласно должностям!
 * demo = Администратор
 * specialist = Специалист
 * volunteer = Волонтер
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');
?>

<?php $this->beginContent('//layouts/main'); ?>
    <div id="overlay" style="display: none" onclick="openMenu()"></div>
    <div id="sidebar" style="display: none">
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Панель администратора',
                    'url' => array('/admin'),
                ),
                array(
                    'label' => 'Все заявки',
                    'url' => array('/requests'),
                ),
                array(
                    'label' => 'Личный кабинет',
                    'url' => array('/office'),
                ),
                array(
                    'label' => 'Волонтеры',
                    'url' => array('/volunteers'),
                ),
                array(
                    'label' => 'Форум',
                    'url' => array('/forum'),
                ),
            ),
        )); ?>
    </div><!-- sidebar -->
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>
