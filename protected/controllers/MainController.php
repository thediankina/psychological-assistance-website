<?php

class MainController extends Controller
{
    public $auth_url = '//login/index';

    public function actionLogin()
    {
        $this->render($this->auth_url);
    }
}
