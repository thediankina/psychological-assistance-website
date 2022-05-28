<?php

namespace application\modules\admin\controllers;

use application\modules\admin\models\Moderation;
use application\modules\office\models\Article;
use CHttpException;
use CLogger;
use Controller;
use User;
use Yii;

class ArticleController extends Controller
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
                'actions' => array('index', 'verify', 'accept', 'return'),
                'roles' => array(User::ROLE_ADMINISTRATOR),
            ),
            array(
                'deny',
                'roles' => User::ROLES_ANYBODY,
            ),
        );
    }

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
        $tags = $model->getTags();
        $this->render('verify', array('model' => $model, 'tags' => $tags));
    }

    /**
     * Публикация статьи
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
     * Возвращение статьи автору
     * @param integer $id
     * @throws CHttpException
     */
    public function actionReturn($id)
    {
        $article = $this->loadModel($id);

        $record = new Moderation();

        if (isset($_POST['application_modules_admin_models_Moderation'])) {
            $record->attributes = $_POST['application_modules_admin_models_Moderation'];
            $record = Moderation::createRecord($article, $record->comment);

            if ($record->save()) {
                Article::model()->updateByPk($id, array('id_status' => Article::MODIFY_STATUS));
                $this->redirect('/admin/articles');
            } else {
                Yii::app()->user->setFlash('error', 'Введите причину');
                Yii::log('Неудачный возврат статьи: ' . var_export($article->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }

        $this->render('return', array(
            'article' => $article,
            'history' => $record,
        ));
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
