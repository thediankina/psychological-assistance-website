<?php

namespace application\modules\admin\controllers;

use application\modules\office\models\Article;
use CHttpException;
use CLogger;
use Controller;
use Yii;

class ArticleController extends Controller
{
	public function actionIndex()
	{
        $model = new Article();
        $model->id_status = "На модерации";
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function actionVerify($id)
    {
        $model = $this->loadModel($id);
        $this->render('verify', array('model' => $model));
    }

    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function actionAccept($id)
    {
        $model = $this->loadModel($id);
        $model->id_status = Article::PUBLISHED_STATUS;
        if ($model->validate() && $model->save()) {
            $this->redirect('/admin/articles');
        } else {
            throw new CHttpException(404, 'Возникла проблема при обработке статьи');
        }
    }

    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function actionReject($id)
    {
        $model = $this->loadModel($id);
        $model->id_status = Article::MODIFY_STATUS;
        if ($model->validate() && $model->save()) {
            $this->redirect('/admin/articles');
        } else {
            throw new CHttpException(404, 'Возникла проблема при обработке статьи');
        }
    }

    /**
     * @param integer $id
     * @return Article
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
