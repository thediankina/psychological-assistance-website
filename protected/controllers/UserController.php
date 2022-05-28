<?php

/**
 * Контроллер пользователей
 */
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
                'deny',
                'actions' => array('save', 'profile'),
                'users' => array('?'),
            ),
        );
    }

    /**
     * Просмотр/редактирование профиля пользователя
     * @param $id
     * @throws CHttpException
     */
    public function actionProfile($id)
    {
        $model = $this->loadModel($id);
        $model->groupIds = $model->getVolunteerGroupIds();
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

            if ($volunteer = Volunteer::model()->findByPk($model->id)) {
                $volunteer->attributes = $_POST['User'];
                $newGroupIds = $_POST['User']['groupIds'];
                $model->groupIds = $model->getVolunteerGroupIds();
                $newGroups = array();
                $removeGroups = array();
                if ($model->groupIds && $newGroupIds) {
                    foreach ($newGroupIds as $newGroup) {
                        if (!in_array($newGroup, $model->groupIds)) {
                            $newGroups[] = $newGroup;
                        }
                    }
                    foreach ($model->groupIds as $oldGroup) {
                        if (!in_array($oldGroup, $newGroupIds)) {
                            $removeGroups[] = $oldGroup;
                        }
                    }
                }
                if ($model->validate() && $model->save()) {
                    if (!empty($newGroups)) {
                        foreach ($newGroups as $groupId) {
                            $record = new VolunteerGroupUser();
                            $record->volunteer_id = $id;
                            $record->group_id = $groupId;
                            $record->param_value = 1;
                            $record->save();
                        }
                    }
                    if (!empty($removeGroups)) {
                        foreach ($removeGroups as $groupId) {
                            $sql = 'DELETE FROM db_users_group_volunteer WHERE volunteer_id = ' . $id . ' AND group_id = ' . $groupId;
                            Yii::app()->db->createCommand($sql)->query();
                        }
                    }
                    if (empty($newGroupIds)) {
                        VolunteerGroupUser::model()->deleteAllByAttributes(array('volunteer_id' => $id));
                    }
                }

                if ($model->validate() && $model->save()) {
                    Yii::app()->user->setFlash('changeProfile', 'Изменения сохранены');
                    $this->redirect('/user/profile?id=' . $model->id);
                } else {
                    Yii::app()->user->setFlash('changeProfile', 'При выполнении этого действия произошла ошибка');
                    Yii::log('Неудачное сохранение пользователя: ' . var_export($model->getErrors(), true),
                        CLogger::LEVEL_WARNING);
                }
            }
            $this->render('profile', array('model' => $model));
        }
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
