<?php

namespace application\modules\forum\controllers;

use application\modules\forum\models\Forum;
use application\modules\forum\models\Topic;
use CHttpException;
use Controller;

class ForumController extends Controller
{
    /**
     * @var string
     */
    public $home_url = '/forum';

	public function actionIndex()
	{
        $forums = Forum::model()->findAll();

        $this->render('index', array(
            'forums' => $forums,
        ));
	}

    /**
     * @param integer $id
     */
    public function actionView($id)
    {
        $forum = $this->loadModel($id);

        $topic = new Topic();
        $topic->id_forum = $id;
        $dataProvider = $topic->search();

        $this->render('view', array(
            'model' => $topic,
            'forum' => $forum,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * @param integer $id
     * @return Forum
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Forum::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}