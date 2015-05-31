<?php
class OrganizationController extends FrontController
{
    public function actionIndex()
    {
        $organizations = Organization::model()->findAll(array(
            'order'=>'sort_order'
        ));

        $this->title('Организации');

        $this->render('list', array(
            'organizations'=>$organizations
        ));
    }

    public function actionShow($organization_id)
    {
        $this->checkCompare('Organization', 'organization_id=:organization_id', array(':organization_id'=>$organization_id), 'организация');

        $organization = Organization::model()->findByPk($organization_id);

        $services = Service::model()->findAll(array(
            'condition'=>'organization_id=:organization_id',
            'params'=>array(':organization_id'=>$organization->organization_id),
            'order'=>'sort_order'
        ));

        $this->title($organization->name);

        $this->render('item', array(
            'organization'=>$organization,
            'services'=>$services
        ));
    }
}