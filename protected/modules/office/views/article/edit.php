<?php
/**
 * @var $this ArticleController
 * @var $model Article
 */

use application\modules\office\controllers\ArticleController;
use application\modules\office\models\Article;

Yii::import('ext.yii-ckeditor.CKEditorWidget');

$this->pageTitle = 'Редактирование статьи #' . $model->id;
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('CKEditorWidget', array(
    'model' => $model,
    'attribute' => 'content',
    // config in extensions\yii-ckeditor\assets\config.js
    'config' => array(
        'language' => 'ru',
    ),
));
