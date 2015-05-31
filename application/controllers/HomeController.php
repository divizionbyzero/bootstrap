<?php
class HomeController extends FrontController
{
    public function actionIndex()
    {
        $this->title('Главная страница');

        $this->render('index');
    }

    public function actionLogin()
    {
        $login_form = new Login();

        if($_POST['Login']){
            $login_form->attributes = $_POST['Login'];
            if($login_form->validate()){
                if(Yii::app()->user->checkAccess('user'))
                    echo 1;
                if(Yii::app()->user->checkAccess('administrator'))
                    echo 2;
            }else{
                $error = $login_form->getError('email');
                $error = $error ? $error : $login_form->getError('password');
                echo $error;
            }
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }
}