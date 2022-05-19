<?php

namespace application\modules\office\controllers;

use Controller;
use User;

class VolunteerController extends Controller
{
    public function actionIndex()
    {
        $model = new User();
        $model->isActive = User::STATUS_ENABLED;
        $model->id_position = User::VOLUNTEER_POSITION;
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }
}
