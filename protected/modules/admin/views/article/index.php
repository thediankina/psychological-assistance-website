<?php
/**
 * Просмотр списка статей, поданных на модерацию
 * @var $this ArticleController
 * @var $model Article
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\admin\controllers\ArticleController;
use application\modules\office\models\Article;

$this->pageTitle = 'Модерация статей';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<menu>
    <?= CHtml::htmlButton('Вернуться', array('submit' => array("/admin"), 'class' => 'back-button')); ?>
</menu>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'summaryText' => 'Всего найдено: ' . $dataProvider->itemCount,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => function ($model) {
                return CHtml::link($model->title, $this->createUrl('/article/verify', array('id' => $model->id)));
            }
        ),
        'category.category_name',
        'status.status',
        array(
            'name' => 'dates_temp',
        ),
        array(
            'header' => 'Автор',
            'name' => 'author.lastName',
            'type' => 'html',
            'value' => function ($model) {
                return CHtml::link($model->author->lastName, $this->createUrl('/user/profile', array('id' => $model->author->id)));
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => function ($model) {
                return $this->createUrl('article/verify', array('id' => $model->id));
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
)); ?>
