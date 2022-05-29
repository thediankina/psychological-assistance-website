<?php
/**
 * @var $this Controller
 * @var $content
 * @todo Изменить условие видимости меню согласно должности волонтера!
 */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/pager.css');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="ru">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

	<title><?= CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<header>
    <div id="header-logo">
        <svg viewBox="70 -15 80 65" xmlns="http://www.w3.org/2000/svg" width="135" height="35" stroke="none" stroke-linecap="round" stroke-linejoin="round" fill="#fff" fill-rule="nonzero">
            <path d="M214.18 1.62v12.97H194.6V1.62h-6.81v32.99h6.81V21.65h19.58v12.96h6.8V1.62h-6.8zm-38.56.23h0l-19.5 23V1.62h-6.8v33h6.8l19.54-23.41v23.58h6.8v-33h-6.8z"/>
            <path d="M143.87 40.04a25.59 25.59 0 0 0-12.43-5.59c7.3545-2.3138 12.3265-9.1705 12.24-16.88 0-9.7-7.57-17.57-16.91-17.57s-16.92 7.87-16.92 17.57c-.0955 7.684 4.8331 14.5313 12.15 16.88-2.7202.4051-5.3655 1.2105-7.85 2.39a22.77 22.77 0 0 0-9.15 7.42c-1.1902 1.6726-2.0864 3.536-2.65 5.51h9.42a12.28 12.28 0 0 1 3.54-4.66c6.5431-5.0483 15.6781-5.0112 22.18.09 1.5134 1.2356 2.7271 2.798 3.55 4.57h9.4a19.12 19.12 0 0 0-6.57-9.73zm-27.41-22.43c-.167-3.7917 1.7607-7.3692 5.0194-9.3149s7.3225-1.9457 10.5812 0 5.1864 5.5232 5.0194 9.3149c.167 3.7917-1.7607 7.3692-5.0194 9.3149s-7.3225 1.9457-10.5812 0-5.1864-5.5232-5.0194-9.3149z" fill="#91d3e2"/>
            <path d="M45.06 27.34v-5.97l17.84-.09-.04-6.8-17.8.09V7.75l23.01-.12-.03-6.8-29.78.15v.14h0V34.1h.37v.07l29.79-.15-.04-6.8-23.32.12zM26.38 14.08H6.8V1.12H0V34.1h6.8V21.14h19.58V34.1h6.8V1.12h-6.8v12.96zM88.65.55c-9.34 0-16.92 7.86-16.92 17.57s7.58 17.57 16.92 17.57 16.91-7.87 16.91-17.57S98 .55 88.65.55zm0 28.28c-5.8026-.1149-10.416-4.9073-10.31-10.71-.167-3.7917 1.7607-7.3692 5.0194-9.3149s7.3225-1.9457 10.5812 0S99.127 14.3283 98.96 18.12c.106 5.8027-4.5074 10.5951-10.31 10.71z"/>
        </svg>
    </div>
    <div id="header-menu">
        <?php if (Yii::app()->user->isGuest): ?>
            <a href="<?= $this->createUrl(Yii::app()->user->loginUrl); ?>">Войти</a>
        <?php else: ?>
            <a href="#"><?= CHtml::link(CHtml::encode(Yii::app()->user->name),
                    $this->createUrl('/user/profile', array('id' => Yii::app()->user->id))); ?>
            </a>
            <?php if (!(Yii::app()->user->role == User::ROLE_VOLUNTEER)): ?>
                <a onclick="openMenu()">Меню</a>
            <?php endif; ?>
            <a href="<?= $this->createUrl('/logout'); ?>">Выйти</a>
        <?php endif; ?>
    </div>
</header>

<?php echo $content; ?>

<footer></footer>
</body>
</html>
