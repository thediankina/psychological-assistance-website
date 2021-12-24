<?php

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
                $this->redirect('/office/office/index');
            }
        }
        $this->render('/login/index', array('model' => $model));
    }

    /**
     * Выход перенаправляет на список заявок
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/request/index');
    }
}
