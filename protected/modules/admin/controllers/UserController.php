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
    /**
     * Отображение запросов
     */
	public function actionIndex()
	{
        $model = new User();
        $model->isActive = User::STATUS_DISABLED;
        //$dataProvider = $model->search();
        $dataProvider = new CActiveDataProvider(User::model(), array(
            'criteria' => array(
                'condition' =>
                    'id_position != ' . User::VOLUNTEER_POSITION .
                    ' AND isActive = ' . User::STATUS_DISABLED,
                'order' => 'id ASC',
            ),
            'pagination' => array('pageSize' => 20),
        ));

        $this->render('index', array(
            'model' => $model,
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

    public function actionApprove($id)
    {
        $model = $this->loadModel($id);
        User::model()->updateByPk($id, array('isActive' => User::STATUS_ENABLED));

        Yii::app()->user->setFlash('activateUser', 'Пользователь успешно зарегистрирован: ' . CHtml::mailto($model->mail));
        $this->redirect('/admin/users');
    }

    /**
     * Удаление запросов на регистрацию из списка (AJAX)
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
