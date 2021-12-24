<?php

class OfficeController extends Controller
{
    public function actionIndex()
    {
        $model = new Request();
        $model->id_user = Yii::app()->user->id;
        $dataProvider = $model->search();

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
}
