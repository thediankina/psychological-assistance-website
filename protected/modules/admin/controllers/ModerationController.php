<?php

namespace application\modules\admin\controllers;

use Controller;
use application\modules\admin\models\Moderation;
use User;
use Yii;

class ModerationController extends Controller
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
                'roles' => array(User::ROLE_ADMINISTRATOR),
            ),
            array(
                'deny',
                'roles' => User::ROLES_ANYBODY,
                'deniedCallback' => array($this, 'deny'),
            ),
        );
    }

    public function deny()
    {
        $message = "Вы не зарегистрированы в качестве администратора";
        Yii::app()->user->setFlash('deniedCallback', $message);
        $this->redirect('/login');
    }

    /**
     * Панель администратора
     */
    public function actionIndex()
    {
        $categories = Moderation::ADMIN_PANEL_CATEGORIES;

        $this->render('index', array(
            'categories' => $categories
        ));
    }
}
