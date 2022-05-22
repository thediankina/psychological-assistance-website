<?php

namespace application\modules\admin\controllers;

use CActiveDataProvider;
use CDbCriteria;
use CDbException;
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
     * Удаление запроса на регистрацию (AJAX)
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
                if (!$model->delete()) {
                    Yii::log('Неудачное удаление запроса на регистрацию: ' . var_export($model->getErrors(), true),
                        CLogger::LEVEL_WARNING);
                }
            }
        } else {
            Yii::log('Неудачное удаление запроса на регистрацию', CLogger::LEVEL_WARNING);
        }

        $this->redirect('/admin/users');
    }
}
