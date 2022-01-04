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
     * @param integer $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            if ($model->validate() && $model->save()) {
                $this->redirect($this->createUrl('/article/view', array('id' => $model->id)));
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
