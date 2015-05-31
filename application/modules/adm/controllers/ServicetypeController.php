<?php
class ServicetypeController extends BackendController
{
    protected $service_type;

    public function actionIndex()
    {
        $service_types = ServiceType::model()->findAll(array(
            'order'=>'sort_order'
        ));

        $this->title('Типы услуг');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Типы услуг'=>false
        ));
        $this->buttons(array(
            'Добавить тип услуг'=>'/adm/servicetype/add'
        ));
        $this->render('list', array(
            'service_types'=>$service_types
        ));
    }

    public function actionAdd()
    {
        $this->service_type = new ServiceType();

        if($this->service_type->saveForm())
        {
            $this->redirect('/adm/servicetype');
        }

        $this->title('Добавление типа услуг');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Типы услуг'=>'/adm/servicetype/',
            'Добавление типа услуг'=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/servicetype'
        ));
        $this->render('form');
    }

    public function actionEdit($id)
    {
        $this->checkCompare('ServiceType', 'service_type_id=:service_type_id', array(':service_type_id'=>$id), 'тип услуг');
        $this->service_type = ServiceType::model()->findByPk($id);

        if($this->service_type->saveForm())
        {
            $this->redirect('/adm/servicetype');
        }

        $this->title('Редактирование типа услуг: '.$this->service_type->name);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Типы услуг'=>'/adm/servicetype/',
            'Редактирование типа услуг: '.$this->service_type->name=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/servicetype'
        ));
        $this->render('form', array(
            'url_attributes'=>'/id/'.$this->service_type->service_type_id
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('ServiceType', 'service_type_id=:service_type_id', array(':service_type_id'=>$id), 'тип услуг');
        ServiceType::model()->deleteByPk($id);
        $this->redirect('/adm/servicetype');
    }

    public function actionOrder()
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $service_type_id=>$sort_order)
            {
                $model = ServiceType::model()->findByPk($service_type_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/servicetype');
    }
}