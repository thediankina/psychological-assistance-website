<?php

namespace application\modules\admin\controllers;

use application\modules\forum\models\Forum;
use CHttpException;
use CLogger;
use Controller;
use User;
use Yii;

class ForumController extends Controller
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
                'actions' => array('index', 'create', 'edit'),
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
        $model = new Forum();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionCreate()
    {
        $model = new Forum();

        if (isset($_POST['application_modules_forum_models_Forum'])) {
            $model->attributes = $_POST['application_modules_forum_models_Forum'];
            if ($model->validate() && $model->save()) {
                $this->redirect('/admin/forums');
            } else {
                Yii::log('Неудачное создание форума: ' . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }
        $this->render('edit', array('model' => $model));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['application_modules_forum_models_Forum'])) {
            $model->attributes = $_POST['application_modules_forum_models_Forum'];
            if ($model->validate() && $model->save()) {
                $this->redirect('/admin/forums');
            } else {
                Yii::log('Неудачное редактирование форума: ' . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }

        $this->render('edit', array('model' => $model));
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
