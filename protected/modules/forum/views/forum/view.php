<?php
/**
 * @var $this ForumController
 * @var $model Topic
 * @var $forum Forum
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\forum\controllers\ForumController;
use application\modules\forum\models\Category;
use application\modules\forum\models\Forum;
use application\modules\forum\models\Topic;

$this->pageTitle = $forum->title;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'topic-form',
    'enableAjaxValidation' => false,
)); ?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $back_url = $this->home_url; ?>
<menu id="forum-menu">
    <?= CHtml::htmlButton('Вернуться', array('submit' => array($back_url), 'class' => 'back-button')); ?>
    <div id="create-topic">
        <?= $form->hiddenField($model, 'id_forum', array('value' => $forum->id)); ?>
        <?= $form->dropDownList($model, 'id_category', CHtml::listData(Category::model()->findAll(), 'id', 'name'),
            array('class' => 'topic-category-field')); ?>
        <?= $form->textField($model, 'title', array('class' => 'topic-title-field', 'placeholder' => 'Введите тему...')); ?>
        <?= CHtml::htmlButton('Добавить', array('submit' => array('topic/create'), 'class' => 'primary-button')); ?>
    </div>
</menu>
<?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => false,
    'columns' => array(
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function ($model) {
                return CHtml::link($model->title, $this->createUrl('topic/view', array('id' => $model->id)));
            }
        ),
        'category.name',
        array(
            'header' => 'Автор',
            'type' => 'html',
            'name' => 'id_author',
            'value' => function ($model) {
                return CHtml::link($model->author->lastName, $this->createUrl('/user/profile', array('id' => $model->author->id)));
            }
        ),
        'public_date',
    ),
)); ?>
