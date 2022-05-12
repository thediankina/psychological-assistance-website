<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Request;
use application\modules\office\models\RequestHistory;
use CHttpException;
use CLogger;
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
    public $homeUrl = '/requests';

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
            'IDrequest' => $model->id),
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
        $request = $this->loadModel($id);
        $request->status = Request::STATUS_IN_WORK;

        $record = RequestHistory::createRecord($request, RequestHistory::ACTION_ACCEPTED);

        if ($record->save() && $request->validate() && $request->save()) {
            $this->redirect($this->homeUrl);
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
        $request = $this->loadModel($id);

        $record = new RequestHistory();

        if (isset($_POST['application_modules_office_models_RequestHistory'])) {

            $record->attributes = $_POST['application_modules_office_models_RequestHistory'];
            $record = RequestHistory::createRecord($request, $record->comment);

            if ($record->save()) {
                Request::model()->updateByPk($id, array('status' => Request::STATUS_REJECTED));
                $record = RequestHistory::createRecord($request, RequestHistory::ACTION_REJECTED);
                if (!$record->save()) {
                    throw new CHttpException(404, 'Возникла проблема при обработке заявки');
                }
                $this->redirect($this->homeUrl);
            } else {
                Yii::app()->user->setFlash('error', 'Введите причину');
                Yii::log('Неудачное отклонение заявки: ' . var_export($request->getErrors(), true),
                    CLogger::LEVEL_WARNING);
            }
        }

        $this->render('reject', array(
            'request' => $request,
            'history' => $record,
        ));
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
