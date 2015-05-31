<?php
class ServiceController extends BackendController
{
    protected $service;

    public function actionIndex()
    {
        $services = Service::model()->findAll(array(
            'order'=>'sort_order'
        ));

        $this->title('Услуги');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>false
        ));
        $this->buttons(array(
            'Добавить услугу'=>'/adm/service/add'
        ));
        $this->render('list', array(
            'services'=>$services
        ));
    }

    public function actionAdd()
    {
        $this->service = new Service();
        $organizations = Organization::model()->findAll(array(
            'order'=>'sort_order'
        ));
        $service_types = ServiceType::model()->findAll(array(
            'order'=>'sort_order'
        ));

        if($this->service->saveForm())
        {
            $this->redirect('/adm/service');
        }

        $this->title('Добавление услуги');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service/',
            'Добавление услуги'=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/service'
        ));
        $this->render('form', array(
            'organizations'=>$organizations,
            'service_types'=>$service_types
        ));
    }

    public function actionEdit($id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$id), 'услуга');

        $this->service = Service::model()->findByPk($id);
        $organizations = Organization::model()->findAll(array(
            'order'=>'sort_order'
        ));
        $service_types = ServiceType::model()->findAll(array(
            'order'=>'sort_order'
        ));

        if($this->service->saveForm())
        {
            $this->redirect('/adm/service');
        }

        $this->title('Редактирование услуги: '.$this->service->title);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service/',
            'Редактирование услуги: '.$this->service->title=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/service'
        ));
        $this->render('form', array(
            'url_attributes'=>'/id/'.$this->service->service_id,
            'organizations'=>$organizations,
            'service_types'=>$service_types
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$id), 'услуга');
        Service::model()->deleteByPk($id);
        $this->redirect('/adm/service');
    }

    public function actionOrder()
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $service_id=>$sort_order)
            {
                $model = Service::model()->findByPk($service_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/service');
    }
}