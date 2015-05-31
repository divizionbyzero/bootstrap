<?php

class AdmModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'adm.models.db.*',
            'adm.models.form.*',
            'adm.components.*',
        ));

        $this->layoutPath = $this->basePath . '/views/layouts';
        $this->layout = 'main';
        $this->defaultController = 'home';
    }

    public function beforeControllerAction($controller, $action)
    {
       if(Yii::app()->user->checkAccess('administrator') || ($controller->id == 'home' && $action->id == 'index')){
            return true;
       }

        Yii::app()->request->redirect('/adm');
    }
}
