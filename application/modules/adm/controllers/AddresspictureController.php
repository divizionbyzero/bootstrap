<?php
class AddresspictureController extends BackendController
{
    protected $picture;

    public function init()
    {
        parent::init();
        $this->active('service');
    }

    public function actionIndex($service_id, $address_id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');

        $pictures = AddressPicture::model()->findAll(array(
            'condition'=>'address_id=:address_id',
            'params'=>array(':address_id'=>$address_id),
            'order'=>'sort_order'
        ));

        $this->title('Галерея изображений');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            Address::model()->findByPk($address_id)->title=>'/adm/address/index/service_id/'.$service_id.'/id/'.$address_id,
            'Галерея изображений'=>false
        ));
        $this->buttons(array(
            'К списку адресов'=>'/adm/address/index/service_id/'.$service_id,
            'Добавить изображение'=>'/adm/addresspicture/add/service_id/'.$service_id.'/address_id/'.$address_id
        ));

        $this->render('list', array(
            'pictures'=>$pictures,
            'service_id'=>$service_id,
            'address_id'=>$address_id
        ));
    }

    public function actionAdd($service_id, $address_id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');

        $this->picture = new AddressPicture();
        $this->picture->setScenario('add');
        $this->picture->address_id = $address_id;

        if($this->picture->saveForm())
        {
            $this->redirect('/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id);
        }

        $this->title('Добавление изображения');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            Address::model()->findByPk($address_id)->title=>'/adm/address/index/service_id/'.$service_id.'/id/'.$address_id,
            'Галерея изображений'=>'/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id,
            'Добавление изображения'=>false
        ));
        $this->buttons(array(
            'К списку изображений'=>'/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id
        ));

        $this->render('form', array(
            'service_id'=>$service_id,
            'address_id'=>$address_id
        ));
    }

    public function actionEdit($service_id, $address_id, $id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');
        $this->checkCompare('AddressPicture', 'picture_id=:picture_id', array(':picture_id'=>$id), 'изображение');

        $this->picture = AddressPicture::model()->findByPk($id);

        if($this->picture->saveForm())
        {
            $this->redirect('/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id);
        }

        $this->title('Редактирование изображения: ['.$this->picture->title.']');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Услуги'=>'/adm/service',
            Service::model()->findByPk($service_id)->title => '/adm/service/edit/id/'.$service_id,
            'Адреса'=>'/adm/address/index/service_id/'.$service_id,
            Address::model()->findByPk($address_id)->title=>'/adm/address/index/service_id/'.$service_id.'/id/'.$address_id,
            'Галерея изображений'=>'/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id,
            'Редактирование изображения: ['.$this->picture->title.']'=>false
        ));
        $this->buttons(array(
            'К списку изображений'=>'/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id,
        ));

        $this->render('form', array(
            'service_id'=>$service_id,
            'address_id'=>$address_id,
            'url_attributes'=>'/id/'.$this->picture->picture_id
        ));
    }

    public function actionDelete($service_id, $address_id, $id)
    {
        $this->checkCompare('Service', 'service_id=:service_id', array(':service_id'=>$service_id), 'услуга');
        $this->checkCompare('Address', 'address_id=:address_id', array(':address_id'=>$address_id), 'адрес');
        $this->checkCompare('AddressPicture', 'picture_id=:picture_id', array(':picture_id'=>$id), 'изображение');

        AddressPicture::model()->findByPk($id)->delete();
        $this->redirect('/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id);
    }

    public function actionOrder($service_id, $address_id)
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $picture_id=>$sort_order)
            {
                $model = AddressPicture::model()->findByPk($picture_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/addresspicture/index/service_id/'.$service_id.'/address_id/'.$address_id);
    }
}