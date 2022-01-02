<?php

namespace application\modules\office\controllers;

use Controller;
use LoginForm;
use Yii;

/**
 * Условный контроллер авторизации
 */
class AuthController extends Controller
{
    /**
     * Условная авторизация для проверки доступа
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
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
