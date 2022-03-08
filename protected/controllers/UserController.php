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
     * Сохранение изменений у существующего пользователя
     * @param $id
     * @throws CHttpException
     */
    public function actionSave($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            $volunteer = Volunteer::model()->findByPk($model->id);
            $volunteer->attributes = $_POST['User'];

            if ($model->validate() & $model->save())
            {
                if ($volunteer->validate()) {
                    $volunteer->save();
                }

                Yii::app()->user->setFlash('changeProfile','Изменения сохранены');
                $this->redirect('/user/profile?id=' . $model->id);
            }
        }
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
