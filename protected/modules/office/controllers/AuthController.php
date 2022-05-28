<?php

namespace application\modules\office\controllers;

use Controller;
use LoginForm;
use User;
use Yii;

/**
 * Условный контроллер авторизации
 */
class AuthController extends Controller
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
                'actions' => array('logout'),
                'roles' => array('@'),
            ),
        );
    }

    /**
     * Условная авторизация для проверки доступа
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                if (Yii::app()->user->role == User::ROLE_ADMINISTRATOR) {
                    $this->redirect('/admin');
                }
                if (Yii::app()->user->role == User::ROLE_VOLUNTEER) {
                    $this->redirect($this->createUrl('/user/profile', array('id' => Yii::app()->user->id)));
                }
                $this->redirect('/office');
            }
        }
        $this->render('login', array('model' => $model));
    }

    /**
     * Условный выход перенаправляет на список заявок
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('login');
    }
}
