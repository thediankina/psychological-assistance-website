<?php

namespace application\modules\admin\controllers;

use CHttpException;
use CLogger;
use Controller;
use User;
use Volunteer;
use Yii;

class VolunteerController extends Controller
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
                'actions' => array('index', 'edit', 'save'),
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
        $model = new User();
        $model->id_position = User::VOLUNTEER_POSITION;
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Редактирование
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);
        $this->render('edit', array('model' => $model));
    }

    /**
     * Сохранение изменений
     * @param $id
     * @throws CHttpException
     */
    public function actionSave($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($volunteer = Volunteer::model()->findByPk($model->id)) {
                $volunteer->attributes = $_POST['User'];
            }

            if ($model->validate() & $model->save())
            {
                if ($volunteer) {
                    if ($volunteer->validate()) {
                        $volunteer->save();
                    }
                }

                Yii::app()->user->setFlash('changeProfile', 'Изменения сохранены');
                $this->redirect('/admin/volunteers');
            } else {
                Yii::app()->user->setFlash('changeProfile', 'При выполнении этого действия произошла ошибка');
                Yii::log('Неудачное сохранение волонтера: ' . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING);
            }
        }
        $this->render('edit', array('model' => $model));
    }

    /**
     * @param integer $id
     * @return User
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}
