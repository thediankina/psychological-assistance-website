<?php

/**
 * Условный контроллер авторизации
 * @package application\controllers
 */
class MainController extends Controller
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
                $this->redirect('/office/office');
            }
        }
        $this->render('/login/index', array('model' => $model));
    }

    /**
     * Условный выход перенаправляет на список заявок
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/office/request');
    }
}
