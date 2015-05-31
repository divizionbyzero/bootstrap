<?php

class HomeController extends BackendController
{
    public function actionIndex()
    {
       $login_form = new LoginForm();

        if($_POST['LoginForm']){
            $login_form->attributes = $_POST['LoginForm'];
            if($login_form->validate()){
                Yii::app()->request->redirect('/adm');
            }
        }

        if(Yii::app()->user->checkAccess('administrator')){
            $this->title('Главная страница');
            $this->render('index');
        }else{
            $this->title('Страница входа');
            $this->renderPartial('login', array(
                'login_form'=>$login_form
            ));
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/adm');
    }

}