<?php
class CityController extends BackendController
{
    protected $city;

    public function actionIndex()
    {
        $cities = City::model()->findAll(array(
            'order'=>'sort_order'
        ));

        $this->title('Города');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Города'=>false
        ));
        $this->buttons(array(
            'Добавить город'=>'/adm/city/add'
        ));
        $this->render('list', array(
            'cities'=>$cities
        ));
    }

    public function actionAdd()
    {
        $this->city = new City();

        if($this->city->saveForm())
        {
            $this->redirect('/adm/city');
        }

        $this->title('Добавление города');
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Города'=>'/adm/city/',
            'Добавление города'=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/city'
        ));
        $this->render('form');
    }

    public function actionEdit($id)
    {
        $this->checkCompare('City', 'city_id=:city_id', array(':city_id'=>$id), 'город');
        $this->city = City::model()->findByPk($id);

        if($this->city->saveForm())
        {
            $this->redirect('/adm/city');
        }

        $this->title('Редактирование города: '.$this->city->name);
        $this->breadcrumbs(array(
            'Главная'=>'/adm',
            'Города'=>'/adm/city/',
            'Редактирование города: '.$this->city->name=>false
        ));
        $this->buttons(array(
            'Вернуться к списку'=>'/adm/city'
        ));
        $this->render('form', array(
            'url_attributes'=>'/id/'.$this->city->city_id
        ));
    }

    public function actionDelete($id)
    {
        $this->checkCompare('City', 'city_id=:city_id', array(':city_id'=>$id), 'город');
        City::model()->deleteByPk($id);
        $this->redirect('/adm/city');
    }

    public function actionOrder()
    {
        if($_POST['SortOrder'] && is_array($_POST['SortOrder']) && count($_POST['SortOrder']))
        {
            foreach($_POST['SortOrder'] as $city_id=>$sort_order)
            {
                $model = City::model()->findByPk($city_id);

                if($model instanceof CActiveRecord)
                {
                    $model->sort_order = $sort_order;
                    $model->save();
                }
            }
        }

        $this->redirect('/adm/city');
    }
}