<?php

/**
 * Контроллер пользователей
 */
class UserController extends Controller
{
    /**
     * Просмотр профиля/анкеты пользователя
     * @param $id
     * @throws CHttpException
     */
    public function actionProfile($id)
    {
        $model = $this->loadModel($id);
        $this->render('profile', array('model' => $model));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionSave($id)
    {
        $model = $this->loadModel($id);
        $this->render('profile', array('model' => $model));
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
