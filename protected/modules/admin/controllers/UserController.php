<?php

namespace application\modules\admin\controllers;

use Controller;
use User;

class UserController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'roles' => array('@'),
            ),
            array(
                'deny',
                'actions' => array('index'),
                'users' => array('?'),
            ),
        );
    }

	public function actionIndex()
	{
        $model = new User();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}
}