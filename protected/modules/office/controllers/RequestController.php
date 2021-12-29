<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Request;
use CHttpException;
use Controller;

/**
 * Контроллер заявок для авторизованного пользователя
 */
class RequestController extends Controller
{
    /**
     * @var string домашний URL списка заявок
     */
    public $home_url = '/requests';

    /**
     * Вывод списка заявок
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
     * Просмотр заявки
     * @param integer $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
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
