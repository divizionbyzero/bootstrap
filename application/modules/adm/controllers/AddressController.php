<?php
class AddressController extends BackendController
{
    protected $address;

    public function init()
    {
        parent::init();
        $this->active('service');
    }

    public function actionIndex($service_id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');

        $addresses = Address::model()->findAll(array(
            'condition'=>'service_id=:service_id',
            'params'=>array(':service_id'=>$service_id),
            'order'=>'sort_order'
        ));

        $this->title('Адреса');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>false
        ));
        $this->buttons(array(
            'К списку услуг'=>'/adm/service',
            'Добавить адрес'=>'/adm/address/add/service_id/'.$service_id
        ));

        $this->render('list', array(
            'addresses'=>$addresses,
            'service_id'=>$service_id
        ));
    }

    public function actionAdd($service_id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');

        $this->address = new Address();
        $this->address->service_id = $service_id;

        $cities = City::model()->findAll(array(
            'order'=>'sort_order'
        ));

        if($this->address->saveForm())
        {
            $this->redirect('/adm/address/index/service_id/'.$service_id);
        }

        $this->title('Добавление адреса');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            'Добавление адреса'=>false
        ));
        $this->buttons(array(
            'К списку адресов'=>'/adm/address/index/service_id/'.$service_id
        ));

        $this->render('form', array(
            'cities'=>$cities,
            'service_id'=>$service_id
        ));
    }

    public function actionEdit($service_id, $id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$id), 'адрес');

        $this->address = Address::model()->findByPk($id);

        $cities = City::model()->findAll(array(
            'order'=>'sort_order'
        ));
        $areas = Area::model()->findAll(array(
            'condition'=>'city_id=:city_id',
            'params'=>array(':city_id'=>$this->address->city_id),
            'order'=>'sort_order'
        ));

        if($this->address->saveForm())
        {
            $this->redirect('/adm/address/index/service_id/'.$service_id);
        }

        $this->title('Редактирование адреса: '.$this->address->title);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            'Редактирование адреса: '.$this->address->title=>false
        ));
        $this->buttons(array(
            'К списку адресов'=>'/adm/address/index/service_id/'.$service_id
        ));

        $this->render('form', array(
            'cities'=>$cities,
            'areas'=>$areas,
            'service_id'=>$service_id,
            'url_attributes'=>'/id/'.$this->address->address_id,
        ));
    }

    public function actionDelete($service_id, $id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$id), 'адрес');

        Address::model()->deleteByPk($id);
        $this->redirect('/adm/address/index/service_id/'.$service_id);
    }

    public function actionOrder($service_id)
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $address_id=>$sort_order)
            {
                $model = Address::model()->findByPk($address_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/address/index/service_id/'.$service_id);
    }
}