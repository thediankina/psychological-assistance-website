<?php
/**
 * @var $this OfficeController
 * @var $Request CActiveDataProvider
 * @var $Article CActiveDataProvider
 */

$this->pageTitle = 'Личный кабинет';
?>

<script>
    function openCity(action, panel) {
        let i, content, links;

        content = document.getElementsByClassName("tab-content");
        for (i = 0; i < content.length; i++) {
            content[i].style.display = "none";
        }

        links = document.getElementsByClassName("tab-button");
        for (i = 0; i < links.length; i++) {
            links[i].className = links[i].className.replace(" active", "");
        }

        document.getElementById(panel).style.display = "block";
        action.currentTarget.className += " active";
    }
</script>

<h1><?php echo $this->pageTitle; ?></h1>

<!-- Tab buttons -->
<div class="tab-buttons">
    <button class="tab-button" onclick="openCity(event, 'requests')" id="default">Заявки, над которыми я работаю</button>
    <button class="tab-button" onclick="openCity(event, 'articles')">Мои статьи</button>
</div>

<!-- Tab content -->
<div id="requests" class="tab-content">
    <?php $this->renderPartial('_requests', array('dataProvider' => $Request)); ?>
</div>
<div id="articles" class="tab-content">
    <?php $this->renderPartial('_articles', array('dataProvider' => $Article)); ?>
</div>

<script>
    document.getElementById("default").click();
</script>
