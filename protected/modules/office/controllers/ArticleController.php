<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use CHttpException;
use CLogger;
use Controller;
use Yii;

/**
 * Контроллер статей
 */
class ArticleController extends Controller
{
    /**
     * Создание статьи (из списка статей)
     */
    public function actionCreate()
    {
        $model = new Article();
        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $model->id_author = Yii::app()->user->id;
            $model->id_status = Article::VERIFICATION_STATUS;
            $model->type = 'psychological';
            if ($model->validate() && $model->save()) {
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error', 'Размер статьи слишком большой');
                Yii::log('Неудачное создание статьи: ' . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }
        $this->render('edit', array('model' => $model));
    }

    /**
     * Редактирование созданной статьи
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
                Yii::log('Неудачное сохранение статьи: ' . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }

        $this->render('edit', array('model' => $model));
    }

    /**
     * Сохранение статьи в список черновиков
     * @param integer $id
     * @throws CHttpException
     */
    public function actionDraft($id)
    {
        if ($id == 0) {
            $model = new Article();
            $model->id_author = Yii::app()->user->id;
            $model->type = 'psychological';
        } else {
            $model = $this->loadModel($id);
        }

        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $model->id_status = Article::DRAFT_STATUS;
            if ($model->validate() && $model->save()) {
                $this->redirect($this->createUrl('/article/view', array('id' => $model->id)));
            } else {
                Yii::app()->user->setFlash('error', 'Размер статьи слишком большой');
                Yii::log('Неудачное сохранение черновой статьи: ' . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }

        $this->render('edit', array('model' => $model));
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
