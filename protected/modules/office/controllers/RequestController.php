<?php

use application\modules\office\models\Request;

/**
 * Контроллер заявок
 * @package application\modules\office
 */
class RequestController extends Controller
{
    /**
     * Стандартный макет для представлений
     * @var string
     */
    public $layout='//layouts/column2';

    /**
     * @return array
     */
    public function filters()
    {
        return array(
            'accessControl', // разрешение доступа для CRUD операций
            'postOnly + delete', // разрешение удаления через POST запрос
        );
    }

    /**
     * Правила доступа
     * @return array
     */
    /**public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index','view','update'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }*/

    /**
     * Просмотр заявки
     * @param integer $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model
        ));
    }

    public function actionAgree()
    {
        $this->render('office/office/index');
    }

    /**
     * Создание заявки (отключено)
     */
    public function actionCreate()
    {
        $model=new Request;

        if(isset($_POST['Request']))
        {
            $model->attributes=$_POST['Request'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Удаление заявки (в разработке)
     * @param integer $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

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
     * Панель администратора (в разработке)
     */
    public function actionAdmin()
    {
        $model=new Request('search');
        $model->unsetAttributes();
        if(isset($_GET['Request']))
            $model->attributes=$_GET['Request'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Возвращает модель данных, основываясь на первичном ключе, полученном из GET запроса
     * @param integer $id
     * @return Request
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Request::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не существует');
        return $model;
    }

    /**
     * Представляет AJAX валидацию (в разработке)
     * @param Request $model
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='request-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
