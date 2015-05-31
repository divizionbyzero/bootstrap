<?php
class UserController extends BackendController
{
    protected $user;
    protected $roles;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'add', 'edit', 'delete'),
                'roles'=>array('super-administrator'),
            ),
            array('deny',
                'actions'=>array('index', 'add', 'edit', 'delete'),
                'users'=>array('*')
            )
        );
    }

    public function init()
    {
        $this->roles = Yii::app()->authManager->getRoles();
        parent::init();
    }

    public function actionIndex()
    {
        $users = AppUser::model()->findAll();

        $this->title('Список пользователей');
        $this->breadcrumbs(array(
            'Главная страница'=>'/adm',
            'Список пользователей'=>false
        ));
        $this->buttons(array(
            'Добавить нового пользователя'=>'/adm/user/add'
        ));

        $this->render('list', array(
            'users'=>$users
        ));
    }

    public function actionAdd()
    {
        $this->user = new AppUser();
        $this->user->setScenario('add');

        if($this->user->saveForm()){
            $this->redirect('/adm/user');
        }

        $this->title('Добавление пользователя');
        $this->breadcrumbs(array(
            'Главная страница'=>'/adm',
            'Список пользователей'=>'/adm/user',
            'Добавление пользователя'=>false
        ));
        $this->buttons(array(
            'Вернуться к списку пользователей'=>'/adm/user'
        ));

        $this->render('form');
    }

    public function actionEdit($id)
    {
        $this->checkCompare('AppUser', 'id_user=:id_user', array(':id_user'=>$id), 'user');

        $this->user = AppUser::model()->findByPk($id);
        $this->user->setScenario('edit');

        if($this->user->saveForm()){
            $this->redirect('/adm/user');
        }

        $this->title('Редактирование пользователя: '.$this->user->first_name.' '.$this->user->last_name);
        $this->breadcrumbs(array(
            'Главная страница'=>'/adm',
            'Список пользователей'=>'/adm/user',
            'Редактирование пользователя: '.$this->user->first_name.' '.$this->user->last_name=>false
        ));
        $this->buttons(array(
            'Вернуться к списку пользователей'=>'/adm/user'
        ));

        $this->render('form', array(
            'url_attributes'=>'/id/'.$this->user->id_user
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('AppUser', 'id_user=:id_user', array(':id_user'=>$id), 'user');

        AppUser::model()->findByPk($id)->delete();
        $this->redirect('/adm/user');
    }
}