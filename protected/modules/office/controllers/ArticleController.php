<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\Request;
use CHttpException;
use Controller;

/**
 * Контроллер статей
 */
class ArticleController extends Controller
{
    /**
     * @todo need to review
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['ArticleForm'])) {
            $model->attributes = $_POST['ArticleForm'];
            if ($model->validate() && $model->save()) {
                $this->redirect('/article/view/'. $id);
            }
        }

        $this->render('edit', array('model' => $model));
    }

    /**
     * @param integer $id
     * @return Request
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Article::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}
