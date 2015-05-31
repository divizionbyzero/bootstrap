<?php
class AccountController extends FrontController
{
    protected $user;

    public function init()
    {
        parent::init();
        if (!Yii::app()->user->checkAccess('user'))
            $this->redirect('/');
    }
    
    public function actionIndex()
    {
        $this->user = AppUser::model()->findByPk(Yii::app()->user->getId());
        $this->title('Аккаунт: '.$this->user->first_name.' '.$this->user->last_name.' ['.$this->user->nickname.']');
        $this->render('info');
    }
}