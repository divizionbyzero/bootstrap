<?php
class RegistrationController extends FrontController
{
    protected $user;

    public function actionIndex()
    {
        $this->user = new AppUser();
        $this->title('Форма регистрации');
        $this->render('form');
    }

    public function actionRun()
    {
        $success = false;
        $this->user = new AppUser();
        $this->user->setScenario('add_user');

        $this->user->role = 'user';
        if($this->user->saveForm()){
            $success = true;
        }

        $this->title('Регистрация');

        $this->render('form', array(
            'success'=>$success
        ));
    }

    public function actionEdit($id)
    {
        $this->checkCompare('AppUser', 'id_user=:id_user', array(':id_user'=>$id), 'пользователь');

        $this->user = AppUser::model()->findByPk($id);
        $this->user->setScenario('edit_user');

        if($this->user->saveForm()){
            $this->redirect('/account');
        }

        $this->title('Редактирование аккаунта');

        $this->render('form');
    }
}