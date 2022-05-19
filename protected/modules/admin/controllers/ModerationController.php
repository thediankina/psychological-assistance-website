<?php

namespace application\modules\admin\controllers;

use Controller;
use application\modules\admin\models\Moderation;

class ModerationController extends Controller
{
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
