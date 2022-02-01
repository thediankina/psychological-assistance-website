<?php

namespace application\modules\forum;

use CWebModule;

class ForumModule extends CWebModule
{
    public $controllerNamespace = 'application\modules\forum\controllers';

	public function init()
	{
		$this->setImport(array(
			'forum.models.*',
			'forum.components.*',
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
