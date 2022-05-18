<?php
/**
 * Просмотр списка статей для неавторизированного пользователя
 * @var $this ArticleController
 * @var $model Article
 * @var $dataProvider CActiveDataProvider
 */

use application\modules\office\models\Article;

$this->pageTitle = 'Статьи';
?>

<h1><?php echo $this->pageTitle; ?></h1>

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
                return CHtml::link($model->title, $this->createUrl('/article/view', array('id' => $model->id)));
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
            'template' => '{update}',
            'updateButtonUrl' => function ($model) {
                return $this->createUrl('/article/edit', array('id' => $model->id));
            }
        ),
    ),
    'pager' => array('class' => OfficePager::class, 'header' => ''),
)); ?>
