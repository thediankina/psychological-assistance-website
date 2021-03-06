<?php

namespace application\modules\admin\controllers;

use CActiveDataProvider;
use CDbCriteria;
use CDbException;
use CHtml;
use CHttpException;
use CLogger;
use Controller;
use User;
use Yii;

class UserController extends Controller
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
                'actions' => array('index', 'view', 'approve', 'remove'),
                'roles' => array(User::ROLE_ADMINISTRATOR),
            ),
            array(
                'deny',
                'roles' => User::ROLES_ANYBODY,
                'deniedCallback' => array($this, 'deny'),
            ),
        );
    }

    public function deny()
    {
        $message = "Вы не зарегистрированы в качестве администратора";
        Yii::app()->user->setFlash('deniedCallback', $message);
        $this->redirect('/login');
    }

    /**
     * Отображение запросов
     */
	public function actionIndex()
	{
        $dataProvider = new CActiveDataProvider(User::model(), array(
            'criteria' => array(
                'condition' =>
                    'id_position NOT IN (' . User::ROLE_VOLUNTEER . ', ' . User::ROLE_MODERATOR . ', ' . User::ROLE_ADMINISTRATOR . ')' .
                    ' AND isActive = ' . User::STATUS_DISABLED,
                'order' => 'id ASC',
            ),
            'pagination' => array('pageSize' => 15),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
	}

    /**
     * Просмотр запроса
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('request', array('model' => $model));
    }

    /**
     * Принятие запроса
     * @param $id
     * @throws CHttpException
     */
    public function actionApprove($id)
    {
        $model = $this->loadModel($id);
        User::model()->updateByPk($id, array('isActive' => User::STATUS_ENABLED));

        Yii::app()->user->setFlash('activateUser', 'Пользователь успешно зарегистрирован: ' . CHtml::mailto($model->mail));
        $this->redirect('/admin/users');
    }

    /**
     * Удаление запросов из списка (AJAX)
     * @throws CDbException
     */
    public function actionRemove()
    {
        if (isset($_POST['ids'])) {
            $ids = explode(',', $_POST['ids']);
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $ids);
            $models = User::model()->findAll($criteria);
            foreach ($models as $model) {
                $model->delete();
            }
        } else {
            Yii::log('Неудачное удаление запроса на регистрацию', CLogger::LEVEL_WARNING);
        }

        $this->redirect('/admin/users');
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
