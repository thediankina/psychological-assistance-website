<?php

class OfficeController extends Controller
{
    public $layout='//layouts/column2';

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Request', array(
            'criteria' => array(
                'condition' => 'subject="Петров"',  // change to lastName
            ),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
}
