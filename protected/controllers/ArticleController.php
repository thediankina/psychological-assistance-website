<?php

use application\modules\office\models\Article;
use application\modules\office\models\Request;

/**
 * Контроллер статей
 * @package application\controllers
 */
class ArticleController extends Controller
{
    /**
     * Просмотр с возможностью редактирования статьи
     * @param $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array('model' => $model));
    }

    /**
     * Возвращает модель данных, основываясь на первичном ключе, полученном из GET запроса
     * @param integer $id
     * @return Request
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Article::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}
