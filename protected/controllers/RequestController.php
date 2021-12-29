<?php

use application\modules\office\models\Request;

/**
 * Контроллер заявок для неавторизованного пользователя
 */
class RequestController extends Controller
{
    /**
     * Создание заявки
     */
    public function actionCreate()
    {
        $model = new Request();
        $this->render('view', array(
            'model' => $model,
        ));
    }
}
