<?php
/**
 * @var $this OfficeController
 * @var $request Request
 * @var $article Article
 */

use application\modules\office\controllers\OfficeController;
use application\modules\office\models\Article;
use application\modules\office\models\Request;

$this->pageTitle = 'Личный кабинет';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('CTabView', array(
    'tabs' => array(
        'requests' => array(
            'title' => 'Заявки',
            'view' => '_requests',
            'data' => $request,
        ),
        'articles' => array(
            'title' => 'Статьи',
            'view' => '_articles',
            'data' => $article,
        ),
    ),
)); ?>
