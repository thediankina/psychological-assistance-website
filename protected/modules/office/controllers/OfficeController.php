<?php

class OfficeController extends Controller
{
    public function actionIndex()
    {
        $requestModel = new Request();
        $requestModel->id_user = Yii::app()->user->id;
        $requestDataProvider = $requestModel->search();

        $articleModel = new Article();
        $articleModel->id_author = Yii::app()->user->id;
        $articleDataProvider = $articleModel->search();

        $this->render('index', array(
            'Request' => $requestDataProvider,
            'Article' => $articleDataProvider
        ));
    }
}
