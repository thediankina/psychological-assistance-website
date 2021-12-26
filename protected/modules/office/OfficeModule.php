<?php

namespace application\modules\office;

use CWebModule;

class OfficeModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'office.models.*',
            'office.components.*',
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
