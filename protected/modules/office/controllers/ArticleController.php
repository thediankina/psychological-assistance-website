<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\ArticleTag;
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
     * Создание статьи (только для кнопки "Добавить" в Личном кабинете)
     */
    public function actionCreate()
    {
        $model = new Article();

        $this->render('edit', array('model' => $model));
    }

    /**
     * Отправка статьи на модерацию
     * @param $id
     * @throws CHttpException
     */
    public function actionSend($id)
    {
        if ($id == 0) {
            $model = new Article();
            $model->id_author = Yii::app()->user->id;
        } else {
            $model = $this->loadModel($id);
        }

        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $model->id_status = Article::VERIFICATION_STATUS;
            $newChosenTags = isset($_POST['application_modules_office_models_Article']['chosenTags']) ?
                $_POST['application_modules_office_models_Article']['chosenTags'] :array();
            $model->chosenTags = $model->getTags();
            $tags = array();
            if ($model->chosenTags && $newChosenTags) {
                foreach ($newChosenTags as $newTag) {
                    if (!in_array($newTag, $model->chosenTags)) {
                        $tags[] = $newTag;
                    }
                }
            } else {
                $tags = $newChosenTags;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        $record = new ArticleTag();
                        $record->id_article = $id;
                        $record->id_tag = $tag;
                        $record->save();
                    }
                }
                if (empty($newChosenTags)) {
                    ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
                }
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error', 'При ' . ($id == 0 ? 'создании' : 'редактировании') .' статьи возникла ошибка');
                Yii::log('Неудачная попытка отправить статью на модерацию: ' . var_export($model->getErrors(), true),
                    CLogger::LEVEL_WARNING);
            }
        }
        $this->render('edit', array('model' => $model));
    }

    /**
     * Редактирование статьи
     * @param integer $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);
        $model->chosenTags = $model->getTags();

        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $newChosenTags = isset($_POST['application_modules_office_models_Article']['chosenTags']) ?
                $_POST['application_modules_office_models_Article']['chosenTags'] :array();
            $model->chosenTags = $model->getTags();
            $tags = array();
            if ($model->chosenTags && $newChosenTags) {
                foreach ($newChosenTags as $newTag) {
                    if (!in_array($newTag, $model->chosenTags)) {
                        $tags[] = $newTag;
                    }
                }
            } else {
                $tags = $newChosenTags;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        $record = new ArticleTag();
                        $record->id_article = $id;
                        $record->id_tag = $tag;
                        $record->save();
                    }
                }
                if (empty($newChosenTags)) {
                    ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
                }
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error', 'При ' . ($id == 0 ? 'создании' : 'редактировании') .' статьи возникла ошибка');
                Yii::log('Неудачное редактирование статьи: ' . var_export($model->getErrors(), true),
                    CLogger::LEVEL_WARNING);
            }
        }

        $this->render('edit', array('model' => $model));
    }

    /**
     * Сохранение статьи как черновик
     * @param integer $id
     * @throws CHttpException
     */
    public function actionDraft($id)
    {
        if ($id == 0) {
            $model = new Article();
            $model->id_author = Yii::app()->user->id;
        } else {
            $model = $this->loadModel($id);
        }

        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $model->id_status = Article::DRAFT_STATUS;
            $newChosenTags = isset($_POST['application_modules_office_models_Article']['chosenTags']) ?
                $_POST['application_modules_office_models_Article']['chosenTags'] :array();
            $model->chosenTags = $model->getTags();
            $tags = array();
            if ($model->chosenTags && $newChosenTags) {
                foreach ($newChosenTags as $newTag) {
                    if (!in_array($newTag, $model->chosenTags)) {
                        $tags[] = $newTag;
                    }
                }
            } else {
                $tags = $newChosenTags;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        $record = new ArticleTag();
                        $record->id_article = $id;
                        $record->id_tag = $tag;
                        $record->save();
                    }
                }
                if (empty($newChosenTags)) {
                    ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
                }
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error', 'При ' . ($id == 0 ? 'создании' : 'редактировании') .' статьи возникла ошибка');
                Yii::log('Неудачное сохранение статьи в черновик: ' . var_export($model->getErrors(), true),
                    CLogger::LEVEL_WARNING);
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
