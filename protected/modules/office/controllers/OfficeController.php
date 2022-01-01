<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\Request;
use Controller;
use Yii;

/**
 * Контроллер личного кабинета
 */
class OfficeController extends Controller
{
    public function actionIndex()
    {
        $requestModel = new Request();
        $id = Yii::app()->user->id;

        $requestModel->id_user = $id;
        $requestData = $requestModel->search();

        $articleModel = new Article();
        $articleModel->id_author = $id;
        $articleData = $articleModel->search();

        $this->render('index', array(
            'requests' => $requestData,
            'articles' => $articleData
        ));
    }
}
