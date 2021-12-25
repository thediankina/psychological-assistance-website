<?php
/**
 * @var $this OfficeController
 * @var $dataProvider CActiveDataProvider
 */

$this->pageTitle = 'Личный кабинет';
?>

<h1><?php echo $this->pageTitle; ?></h1>
<?php $this->renderPartial('_list', array('dataProvider' => $dataProvider)); ?>
