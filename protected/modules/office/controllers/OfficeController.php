<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\Request;
use Controller;
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

    public function actionIndex()
    {
        $request = new Request();
        $request->executor_id = Yii::app()->user->id;

        $article = new Article();
        $article->id_author = Yii::app()->user->id;

        $this->render('index', array(
            'request' => $request,
            'article' => $article,
        ));
    }
}
