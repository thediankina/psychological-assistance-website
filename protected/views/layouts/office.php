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
                    'visible' => !(in_array(Yii::app()->user->role, User::ROLES_ANYBODY)),
                ),
                array(
                    'label' => 'Все заявки',
                    'url' => array('/requests'),
                    'visible' => in_array(Yii::app()->user->role, User::ROLES_SPECIALIST)
                ),
                array(
                    'label' => 'Личный кабинет',
                    'url' => array('/office'),
                    'visible' => in_array(Yii::app()->user->role, User::ROLES_SPECIALIST)
                ),
                array(
                    'label' => 'Волонтеры',
                    'url' => array('/volunteers'),
                    'visible' => in_array(Yii::app()->user->role, User::ROLES_SPECIALIST)
                ),
                array(
                    'label' => 'Форум',
                    'url' => array('/forum'),
                    'visible' => in_array(Yii::app()->user->role, User::ROLES_SPECIALIST)
                ),
            ),
        )); ?>
    </div><!-- sidebar -->
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>
