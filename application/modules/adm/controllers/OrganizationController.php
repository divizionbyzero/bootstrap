<?php
class OrganizationController extends BackendController
{
    protected $organization;

    public function actionIndex()
    {
        $organizations = Organization::model()->findAll(array(
            'order'=>'sort_order'
        ));

        $this->title('Организации');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Организации'=>false
        ));
        $this->buttons(array(
            'Добавить организацию'=>'/adm/organization/add'
        ));
        $this->render('list', array(
            'organizations'=>$organizations
        ));
    }

    public function actionAdd()
    {
        $this->organization = new Organization();
        if($this->organization->saveForm())
        {
            $this->redirect('/adm/organization');
        }

        $this->title('Добавление новой организации');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Организации'=>'/adm/organization',
            'Добавление новой организации'=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/organization'
        ));

        $this->render('form');
    }

    public function actionEdit($id)
    {
        $this->checkCompare('Organization', 'organization_id=:organization_id', array(':organization_id'=>$id), 'организация');
        $this->organization = Organization::model()->findByPk($id);
        if($this->organization->saveForm())
        {
            $this->redirect('/adm/organization');
        }

        $this->title('Изменение организации:'.$this->organization->name);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Организации'=>'/adm/organization',
            'Изменение организации:'.$this->organization->name=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/organization'
        ));

        $this->render('form',array(
            'url_attributes'=>'/id/'.$this->organization->organization_id
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('Organization', 'organization_id=:organization_id', array(':organization_id'=>$id), 'организация');
        Organization::model()->deleteByPk($id);
        $this->redirect('/adm/organization');
    }

    public function actionOrder()
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $organization_id=>$sort_order)
            {
               $model = Organization::model()->findByPk($organization_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/organization');
    }
}