<?php

namespace application\modules\admin\controllers;

use CArrayDataProvider;
use Controller;
use application\modules\admin\models\Moderation;

class ModerationController extends Controller
{
    /**
     * Узловой интерфейс панели администратора
     */
    public function actionIndex()
    {
        $categories = Moderation::ADMIN_PANEL_CATEGORIES;

        $this->render('index', array('categories' => $categories));
    }
}
