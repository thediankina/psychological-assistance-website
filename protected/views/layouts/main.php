<?php
/**
 * @var $this Controller
 * @var $content
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="mainmenu">
    <?php $menuLabels = array(
        'menu' => 'Меню',
        'username' => Yii::app()->user->name,
        'account' => 'Моя учетная запись',
        'logout' => 'Выйти',
    ); ?>
    <?php $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => $menuLabels['menu'], 'url' => array('/site/index')),
            array('label' => $menuLabels['username'], 'url' => array('/site/contact'), 'visible' => Yii::app()->user->isGuest, 'class' => 'right-side-menu'),
            array('label' => $menuLabels['account'], 'url' => array('/site/contact'), 'visible' => Yii::app()->user->isGuest, 'class' => 'right-side-menu'),
            array('label' => $menuLabels['logout'] , 'url' => array('/site/logout'), 'visible' => Yii::app()->user->isGuest, 'class' => 'right-side-menu')
        ),
    )); ?>
</div><!-- mainmenu -->

<?php echo $content; ?>

<div class="clear"></div>

</body>
</html>
