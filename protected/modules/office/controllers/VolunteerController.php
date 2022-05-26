<?php

namespace application\modules\office\controllers;

use Controller;
use User;

class VolunteerController extends Controller
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
                'roles' => User::ROLES_SPECIALIST,
            ),
            array(
                'deny',
                'roles' => array(
                    User::ROLE_GUEST,
                    User::ROLE_ADMINISTRATOR,
                    User::ROLE_VOLUNTEER,
                ),
            ),
        );
    }

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
