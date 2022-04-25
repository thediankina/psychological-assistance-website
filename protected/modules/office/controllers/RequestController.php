<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Request;
use application\modules\office\models\RequestHistory;
use CHttpException;
use Controller;
use Yii;

/**
 * Контроллер заявок для авторизованного пользователя
 */
class RequestController extends Controller
{
    /**
     * @var string домашний URL
     */
    public $home_url = '/requests';

    /**
     * Список заявок
     */
    public function actionIndex()
    {
        $model = new Request();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $history = RequestHistory::model()->findByAttributes(array(
            'IDuser' => Yii::app()->user->id,
            'IDrequest' => $model->id
        ),
            array('order' => 'id DESC', 'limit' => 1));

        $this->render('view', array(
            'model' => $model,
            'history' => $history
        ));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionAccept($id)
    {
        $model = $this->loadModel($id);
        $model->status = "В работе";

        $record = new RequestHistory();
        $record->IDuser = Yii::app()->user->id;
        $record->IDrequest = $model->id;
        $record->comment = "Принято";
        $record->dateOfComment = date('Y-m-d');

        if ($record->validate() && $record->save() &&
            $model->validate() && $model->save()) {
            $this->redirect($this->home_url);
        }
        else {
            throw new CHttpException(404, 'Возникла проблема при обработке заявки');
        }
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionReject($id)
    {
        $model = $this->loadModel($id);
        $model->status = "Отклонена";

        $record = new RequestHistory();
        $record->IDuser = Yii::app()->user->id;
        $record->IDrequest = $model->id;
        $record->comment = "Отклонено";
        $record->dateOfComment = date('Y-m-d');

        if ($record->validate() && $record->save() &&
            $model->validate() && $model->save()) {
            $this->redirect($this->home_url);
        }
        else {
            throw new CHttpException(404, 'Возникла проблема при обработке заявки');
        }
    }

    /**
     * @todo Реализовать завершение заявки
     * @param $id
     */
    public function actionFinish($id)
    {
    }

    /**
     * @param integer $id
     * @return Request
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Request::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}
