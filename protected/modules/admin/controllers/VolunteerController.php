<?php

namespace application\modules\admin\controllers;

use CActiveDataProvider;
use CHttpException;
use CLogger;
use Controller;
use User;
use Volunteer;
use VolunteerGroupUser;
use Yii;

class VolunteerController extends Controller
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
                'allow',
                'actions' => array('index', 'edit', 'save'),
                'roles' => array(User::ROLE_ADMINISTRATOR),
            ),
            array(
                'deny',
                'roles' => User::ROLES_ANYBODY,
                'deniedCallback' => array($this, 'deny'),
            ),
        );
    }

    public function deny()
    {
        $message = "Вы не зарегистрированы в качестве администратора";
        Yii::app()->user->setFlash('deniedCallback', $message);
        $this->redirect('/login');
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(User::model(), array(
            'criteria' => array(
                'condition' =>
                    'id_position = ' . User::VOLUNTEER_POSITION .
                    ' AND isActive IN (' . User::STATUS_DISABLED . ', ' . User::STATUS_ENABLED . ')',
                'order' => 'id ASC',
            ),
            'pagination' => array('pageSize' => 20),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Редактирование
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);
        $model->groupIds = $model->getVolunteerGroupIds();
        $this->render('edit', array('model' => $model));
    }

    /**
     * Сохранение изменений профиля волонтера
     * @param $id
     * @throws CHttpException
     */
    public function actionSave($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            $volunteer = Volunteer::model()->findByPk($model->id);
            if ($volunteer == null) {
                $volunteer = new Volunteer();
                $volunteer->id = $id;
            }
            $volunteer->other = '';
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

            if ($model->save() && $volunteer->save()) {
                if (empty($newGroupIds) && $model->groupIds) {
                    VolunteerGroupUser::model()->deleteAllByAttributes(array('volunteer_id' => $volunteer->id));
                }
                elseif (empty($model->groupIds) && $newGroupIds) {
                    foreach ($newGroupIds as $groupId) {
                        $record = new VolunteerGroupUser();
                        $record->volunteer_id = $volunteer->id;
                        $record->group_id = $groupId;
                        $record->param_value = 1;
                        $record->save();
                    }
                }
                if (!empty($newGroups)) {
                    foreach ($newGroups as $groupId) {
                        $record = new VolunteerGroupUser();
                        $record->volunteer_id = $volunteer->id;
                        $record->group_id = $groupId;
                        $record->param_value = 1;
                        $record->save();
                    }
                }
                if (!empty($removeGroups)) {
                    foreach ($removeGroups as $groupId) {
                        $sql = 'DELETE FROM db_users_group_volunteer WHERE volunteer_id = ' . $volunteer->id . ' AND group_id = ' . $groupId;
                        Yii::app()->db->createCommand($sql)->query();
                    }
                }
                if (empty($newGroupIds)) {
                    VolunteerGroupUser::model()->deleteAllByAttributes(array('volunteer_id' => $volunteer->id));
                }

                Yii::app()->user->setFlash('changeProfile', 'Изменения сохранены');
                $this->redirect('/admin/volunteers');
            } else {
                Yii::app()->user->setFlash('changeProfile', 'При выполнении этого действия произошла ошибка');
                Yii::log('Неудачное сохранение волонтера: ' . var_export($volunteer->getErrors(), true));
            }

            $this->render('edit', array('model' => $model));
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
