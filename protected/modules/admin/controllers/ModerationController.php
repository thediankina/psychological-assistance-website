<?php

namespace application\modules\admin\controllers;

use Controller;
use application\modules\admin\models\Moderation;
use User;

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
            ),
        );
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
