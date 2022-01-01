<?php
/**
 * @var $this OfficeController
 * @var $requests CActiveDataProvider
 * @var $articles CActiveDataProvider
 */

use application\modules\office\controllers\OfficeController;

$this->pageTitle = 'Личный кабинет';
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->widget('CTabView', array(
    'tabs' => array(
        'requests' => array(
            'title' => 'Заявки, над которыми я работаю',
            'view' => '_requests',
            'data' => $requests,
        ),
        'articles' => array(
            'title' => 'Мои статьи',
            'view' => '_articles',
            'data' => $articles,
        ),
    ),
)); ?>
