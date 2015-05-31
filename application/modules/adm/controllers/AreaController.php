<?php
class AreaController extends BackendController
{
    protected $area;

    public function actionIndex()
    {
        $areas = Area::model()->findAll(array(
            'order' => 'sort_order'
        ));

        $this->title('Районы');
        $this->breadcrumbs(array(
            'Главная' => '/adm',
            'Районы' => false
        ));
        $this->buttons(array(
            'Добавить район' => '/adm/area/add'
        ));
        $this->render('list', array(
            'areas' => $areas
        ));
    }

    public function actionAdd()
    {
        $this->area = new Area();

        $cities = City::model()->findAll(array(
            'order' => 'sort_order'
        ));

        if ($this->area->saveForm()) {
            $this->redirect('/adm/area');
        }

        $this->title('Добавление района');
        $this->breadcrumbs(array(
            'Главная' => '/adm',
            'Районы' => '/adm/area/',
            'Добавление района' => false
        ));
        $this->buttons(array(
            'Вернуться к списку' => '/adm/area'
        ));
        $this->render('form', array(
            'cities' => $cities
        ));
    }

    public function actionEdit($id)
    {
        $this->checkCompare('Area', 'area_id=:area_id', array(':area_id' => $id), 'район');
        $this->area = Area::model()->findByPk($id);

        $cities = City::model()->findAll(array(
            'order' => 'sort_order'
        ));

        if ($this->area->saveForm()) {
            $this->redirect('/adm/area');
        }

        $this->title('Редактирование района: ' . $this->area->name);
        $this->breadcrumbs(array(
            'Главная' => '/adm',
            'Районы' => '/adm/area/',
            'Редактирование района: ' . $this->area->name => false
        ));
        $this->buttons(array(
            'Вернуться к списку' => '/adm/area'
        ));
        $this->render('form', array(
            'url_attributes' => '/id/' . $this->area->area_id,
            'cities' => $cities
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('Area', 'area_id=:area_id', array(':area_id' => $id), 'район');
        Area::model()->deleteByPk($id);
        $this->redirect('/adm/area');
    }

    public function actionOrder()
    {
        if ($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder'])) {
            foreach ($_POST['SortOrder'] as $area_id => $sort_order) {
                $model = Area::model()->findByPk($area_id);

                if ($model instanceof CActiveRecord) {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/area');
    }

    public function actionGet($city_id)
    {
        $this->checkCompare('City', 'city_id=:city_id', array(':city_id' => $city_id), 'город');

        $areas = Area::model()->findAll(array(
            'condition' => 'city_id=:city_id',
            'params' =>array(':city_id' => $city_id),
            'order' => 'sort_order'
        ));

        if($areas && count($areas) && is_array($areas))
        {
            $output = '<option value="">пожалуйста, выберите</option>';
            foreach($areas as $area)
            {
                $output .= '<option value="'.$area->area_id.'">'.$area->name.'</option>';
            }

            echo $output;
        }else{
            echo '<option value="">пожалуйста, выберите</option>';
        }
    }
}