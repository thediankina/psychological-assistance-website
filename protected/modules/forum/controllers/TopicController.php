<?php

namespace application\modules\forum\controllers;

use application\modules\forum\models\Comment;
use application\modules\forum\models\Topic;
use CActiveForm;
use CHttpException;
use Controller;
use Yii;

class TopicController extends Controller
{
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $comment = $this->commentTopic($model);

        $this->render('view', array(
            'model' => $model,
            'comment' => $comment,
        ));
    }

    /**
     * @param $topic Topic
     * @return Comment
     */
    protected function commentTopic($topic)
    {
        $comment = new Comment;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        if (isset($_POST['application_modules_forum_models_Comment'])) {
            $comment->attributes = $_POST['application_modules_forum_models_Comment'];
            if ($comment->validate() && $comment->save()) {
                Yii::app()->user->setFlash('success', 'Ваш комментарий успешно добавлен');
                $this->refresh();
            }
        }
        return $comment;
    }

    /**
     * @param integer $id
     * @return Topic
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Topic::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}
