<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\Request;
use CHttpException;
use Controller;
use Yii;

/**
 * Контроллер статей
 */
class ArticleController extends Controller
{
    const PUBLISHED_STATUS = 1; // Опубликовано
    const DRAFT_STATUS = 2; // Черновик
    const VERIFICATION_STATUS = 3;  // На проверке

    /**
     * Создание статьи (из списка статей)
     */
    public function actionCreate()
    {
        $model = new Article();
        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $model->id_author = Yii::app()->user->id;
            $model->id_status = self::VERIFICATION_STATUS;
            $model->type = 'psychological';
            if ($model->validate() && $model->save()) {
                $this->redirect('/articles');
            } else {
                Yii::app()->user->setFlash('error', 'Размер статьи слишком большой');
            }
        }
        $this->render('edit', array('model' => $model));
    }

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
            } else {
                Yii::app()->user->setFlash('error', 'Размер статьи слишком большой');
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
