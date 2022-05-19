<?php

namespace application\modules\admin\controllers;

use Controller;
use User;

class VolunteerController extends Controller
{
    public function actionIndex()
    {
        $model = new User();
        $model->id_position = User::VOLUNTEER_POSITION;
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }
}
