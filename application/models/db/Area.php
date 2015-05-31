<?php
class Area extends CActiveRecord
{
    public  $city;

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'area';
    }

    public function rules()
    {
        return array(
            array('city_id, name', 'required'),
            array('sort_order', 'numerical'),
        );
    }

    public function saveForm()
    {
        if($_POST['Area'])
        {
            $this->attributes = $_POST['Area'];
            if($this->validate()){
                $this->save();
                return true;
            }
        }
        return false;
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
        {
            $sort_order = Yii::app()->db->createCommand('
                SELECT MAX(`sort_order`)
                FROM  `area`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->city = City::model()->findByPk($this->city_id)->name;
        return parent::afterFind();
    }
}