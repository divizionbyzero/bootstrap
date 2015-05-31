<?php
class ContactController extends BackendController
{
    protected $contact;

    public function init()
    {
        parent::init();
        $this->active('service');
    }

    public function actionIndex($service_id, $address_id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');

        $contacts = Contact::model()->findAll(array(
            'condition'=>'address_id=:address_id',
            'params'=>array(':address_id'=>$address_id),
            'order'=>'sort_order'
        ));

        $this->title('Контакты');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            Address::model()->findByPk($address_id)->title=>'/adm/address/index/service_id/'.$service_id.'/id/'.$address_id,
            'Контакты'=>false
        ));
        $this->buttons(array(
            'К списку адресов'=>'/adm/address/index/service_id/'.$service_id,
            'Добавить контакт'=>'/adm/contact/add/service_id/'.$service_id.'/address_id/'.$address_id
        ));

        $this->render('list', array(
            'contacts'=>$contacts,
            'service_id'=>$service_id,
            'address_id'=>$address_id
        ));
    }

    public function actionAdd($service_id, $address_id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');

        $this->contact = new Contact();
        $this->contact->address_id = $address_id;

        $contact_types = ContactType::model()->findAll(array(
            'order'=>'sort_order'
        ));

        if($this->contact->saveForm())
        {
            $this->redirect('/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id);
        }

        $this->title('Добавление контакта');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            Address::model()->findByPk($address_id)->title=>'/adm/address/index/service_id/'.$service_id.'/id/'.$address_id,
            'Контакты'=>'/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id,
            'Добавление контакта'=>false
        ));
        $this->buttons(array(
            'К списку контактов'=>'/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id
        ));

        $this->render('form', array(
            'contact_types'=>$contact_types,
            'service_id'=>$service_id,
            'address_id'=>$address_id
        ));
    }

    public function actionEdit($service_id, $address_id, $id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');
        $this->checkCompare('Contact', 'contact_id=:contact_id', array(':contact_id'=>$id), 'контакт');

        $this->contact = Contact::model()->findByPk($id);

        $contact_types = ContactType::model()->findAll(array(
            'order'=>'sort_order'
        ));

        if($this->contact->saveForm())
        {
            $this->redirect('/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id);
        }

        $this->title('Редактирование контакта: ['.$this->contact->type.'] - '.$this->contact->contact);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            Address::model()->findByPk($address_id)->title=>'/adm/address/index/service_id/'.$service_id.'/id/'.$address_id,
            'Контакты'=>'/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id,
            'Редактирование контакта: ['.$this->contact->type.'] - '.$this->contact->contact=>false
        ));
        $this->buttons(array(
            'К списку контактов'=>'/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id
        ));

        $this->render('form', array(
            'contact_types'=>$contact_types,
            'service_id'=>$service_id,
            'address_id'=>$address_id,
            'url_attributes'=>'/id/'.$this->contact->contact_id
        ));
    }

    public function actionDelete($service_id, $address_id, $id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');
        $this->checkCompare('Contact', 'contact_id=:contact_id', array(':contact_id'=>$id), 'контакт');

        Contact::model()->deleteByPk($id);
        $this->redirect('/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id);
    }

    public function actionOrder($service_id, $address_id)
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $contact_id=>$sort_order)
            {
                $model = Contact::model()->findByPk($contact_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/contact/index/service_id/'.$service_id.'/address_id/'.$address_id);
    }
}