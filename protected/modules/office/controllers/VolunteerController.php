<?php

namespace application\modules\office\controllers;

use Controller;
use User;
use Yii;

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
                'deniedCallback' => array($this, 'deny'),
            ),
        );
    }

    public function deny()
    {
        $message = "Вы не зарегистрированы в качестве специалиста";
        Yii::app()->user->setFlash('deniedCallback', $message);
        $this->redirect('/login');
    }

    public function actionIndex()
    {
        $model = new User();
        $model->isActive = User::STATUS_ENABLED;
        $model->id_position = User::ROLE_VOLUNTEER;
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }
}
