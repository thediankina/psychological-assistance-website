<?php

namespace application\modules\admin;

use CWebModule;

class AdminModule extends CWebModule
{
    public $controllerNamespace = 'application\modules\admin\controllers';

	public function init()
	{
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
