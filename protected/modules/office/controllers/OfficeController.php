<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\Request;
use Controller;
use User;
use Yii;

/**
 * Контроллер личного кабинета
 */
class OfficeController extends Controller
{
    /**
     * @var string
     */
    public $home_url = '/office';

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
                'message' => 'Вы не зарегистрированы',
            ),
        );
    }

    public function actionIndex()
    {
        $user_id = Yii::app()->user->id;

        $request = new Request();
        $request->executor_id = $user_id;

        $article = new Article();
        $article->id_author = $user_id;

        $this->render('index', array(
            'request' => $request,
            'article' => $article,
        ));
    }
}
