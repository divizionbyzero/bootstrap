<?php
class ContacttypeController extends BackendController
{
    protected $contact_type;

    public function actionIndex()
    {
        $contact_types = ContactType::model()->findAll(array(
            'order'=>'sort_order'
        ));

        $this->title('Типы контактов');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Типы контактов'=>false
        ));
        $this->buttons(array(
            'Добавить тип контактов'=>'/adm/contacttype/add'
        ));
        $this->render('list', array(
            'contact_types'=>$contact_types
        ));
    }

    public function actionAdd()
    {
        $this->contact_type = new ContactType();

        if($this->contact_type->saveForm())
        {
            $this->redirect('/adm/contacttype');
        }

        $this->title('Добавление типа контактов');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Типы контактов'=>'/adm/contacttype/',
            'Добавление типа контактов'=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/contacttype'
        ));
        $this->render('form');
    }

    public function actionEdit($id)
    {
        $this->checkCompare('ContactType', 'contact_type_id=:contact_type_id', array(':contact_type_id'=>$id), 'тип контактов');
        $this->contact_type = ContactType::model()->findByPk($id);

        if($this->contact_type->saveForm())
        {
            $this->redirect('/adm/contacttype');
        }

        $this->title('Редактирование типа контактов: '.$this->contact_type->name);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Типы контактов'=>'/adm/contacttype/',
            'Редактирование типа контактов: '.$this->contact_type->name=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/contacttype'
        ));
        $this->render('form', array(
            'url_attributes'=>'/id/'.$this->contact_type->contact_type_id
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('ContactType', 'contact_type_id=:contact_type_id', array(':contact_type_id'=>$id), 'тип контактов');
        ContactType::model()->deleteByPk($id);
        $this->redirect('/adm/contacttype');
    }

    public function actionOrder()
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $contact_type_id=>$sort_order)
            {
                $model = ContactType::model()->findByPk($contact_type_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/contacttype');
    }
}