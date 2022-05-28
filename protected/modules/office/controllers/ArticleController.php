<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Article;
use application\modules\office\models\ArticleTag;
use CHttpException;
use CLogger;
use Controller;
use User;
use Yii;

/**
 * Контроллер статей
 */
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
                'actions' => array('create', 'send', 'edit', 'draft'),
                'roles' => User::ROLES_SPECIALIST,
            ),
            array(
                'deny',
                'roles' => array(
                    User::ROLE_GUEST,
                    User::ROLE_ADMINISTRATOR,
                    User::ROLE_VOLUNTEER,
                ),
            ),
        );
    }

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
                $_POST['application_modules_office_models_Article']['chosenTags'] : array();
            $model->chosenTags = $model->getTags();
            $removeTags = array();
            $newTags = array();
            if ($model->chosenTags && $newChosenTags) {
                foreach ($newChosenTags as $newTag) {
                    if (!in_array($newTag, $model->chosenTags)) {
                        $newTags[] = $newTag;
                    }
                }
                foreach ($model->chosenTags as $oldTag) {
                    if (!in_array($oldTag, $newChosenTags)) {
                        $removeTags[] = $oldTag;
                    }
                }
            }
            if (empty($newChosenTags) && $model->chosenTags) {
                ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
            }
            if (empty($model->chosenTags) && $newChosenTags) {
                foreach ($newChosenTags as $tag) {
                    $record = new ArticleTag();
                    $record->id_article = $id;
                    $record->id_tag = $tag;
                    $record->save();
                }
            }
            if ($model->validate() && $model->save()) {
                if (!empty($newTags)) {
                    foreach ($newTags as $tag) {
                        $record = new ArticleTag();
                        $record->id_article = $id;
                        $record->id_tag = $tag;
                        $record->save();
                    }
                }
                if (!empty($removeTags)) {
                    foreach ($removeTags as $tag) {
                        $sql = 'DELETE FROM db_article_tags WHERE id_article = ' . $id . ' AND id_tag = ' . $tag;
                        Yii::app()->db->createCommand($sql)->query();
                    }
                }
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error',
                    'При ' . ($id == 0 ? 'создании' : 'редактировании') . ' статьи возникла ошибка');
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
        $model->type = array_search($model->type, $model->types);

        if (isset($_POST['application_modules_office_models_Article'])) {
            $model->attributes = $_POST['application_modules_office_models_Article'];
            $newChosenTags = isset($_POST['application_modules_office_models_Article']['chosenTags']) ?
                $_POST['application_modules_office_models_Article']['chosenTags'] : array();
            $model->chosenTags = $model->getTags();
            $removeTags = array();
            $newTags = array();
            if ($model->chosenTags && $newChosenTags) {
                foreach ($newChosenTags as $newTag) {
                    if (!in_array($newTag, $model->chosenTags)) {
                        $newTags[] = $newTag;
                    }
                }
                foreach ($model->chosenTags as $oldTag) {
                    if (!in_array($oldTag, $newChosenTags)) {
                        $removeTags[] = $oldTag;
                    }
                }
            }
            if (empty($newChosenTags) && $model->chosenTags) {
                ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
            }
            if (empty($model->chosenTags) && $newChosenTags) {
                foreach ($newChosenTags as $tag) {
                    $record = new ArticleTag();
                    $record->id_article = $id;
                    $record->id_tag = $tag;
                    $record->save();
                }
            }
            if ($model->validate() && $model->save()) {
                if (!empty($newTags)) {
                    foreach ($newTags as $tag) {
                        $record = new ArticleTag();
                        $record->id_article = $id;
                        $record->id_tag = $tag;
                        $record->save();
                    }
                }
                if (!empty($removeTags)) {
                    foreach ($removeTags as $tag) {
                        $sql = 'DELETE FROM db_article_tags WHERE id_article = ' . $id . ' AND id_tag = ' . $tag;
                        Yii::app()->db->createCommand($sql)->query();
                    }
                }
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error',
                    'При ' . ($id == 0 ? 'создании' : 'редактировании') . ' статьи возникла ошибка');
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
                $_POST['application_modules_office_models_Article']['chosenTags'] : array();
            $model->chosenTags = $model->getTags();
            $removeTags = array();
            $newTags = array();
            if ($model->chosenTags && $newChosenTags) {
                foreach ($newChosenTags as $newTag) {
                    if (!in_array($newTag, $model->chosenTags)) {
                        $newTags[] = $newTag;
                    }
                }
                foreach ($model->chosenTags as $oldTag) {
                    if (!in_array($oldTag, $newChosenTags)) {
                        $removeTags[] = $oldTag;
                    }
                }
            }
            if (empty($newChosenTags) && $model->chosenTags) {
                ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
            }
            if (empty($model->chosenTags) && $newChosenTags) {
                foreach ($newChosenTags as $tag) {
                    $record = new ArticleTag();
                    $record->id_article = $id;
                    $record->id_tag = $tag;
                    $record->save();
                }
            }
            if ($model->validate() && $model->save()) {
                if (!empty($newTags)) {
                    foreach ($newTags as $tag) {
                        $record = new ArticleTag();
                        $record->id_article = $id;
                        $record->id_tag = $tag;
                        $record->save();
                    }
                }
                if (!empty($removeTags)) {
                    foreach ($removeTags as $tag) {
                        $sql = 'DELETE FROM db_article_tags WHERE id_article = ' . $id . ' AND id_tag = ' . $tag;
                        Yii::app()->db->createCommand($sql)->query();
                    }
                }
                if (empty($newChosenTags)) {
                    ArticleTag::model()->deleteAllByAttributes(array('id_article' => $id));
                }
                $this->redirect('/office');
            } else {
                Yii::app()->user->setFlash('error',
                    'При ' . ($id == 0 ? 'создании' : 'редактировании') . ' статьи возникла ошибка');
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
