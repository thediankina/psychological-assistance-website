<?php

use application\modules\office\models\Article;
use application\modules\office\models\Request;

/**
 * Контроллер личного кабинета
 * @package application\modules\office
 */
class OfficeController extends Controller
{
    public function actionIndex()
    {
        $requestModel = new Request();
        $id = Yii::app()->user->id;

        $requestModel->id_user = $id;
        $requestDataProvider = $requestModel->search();

        $articleModel = new Article();
        $articleModel->id_author = $id;
        $articleDataProvider = $articleModel->search();

        $this->render('index', array(
            'Request' => $requestDataProvider,
            'Article' => $articleDataProvider
        ));
    }
}
