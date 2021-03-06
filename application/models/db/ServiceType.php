<?php
class ServiceType extends CActiveRecord
{
    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'service_type';
    }

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('sort_order', 'numerical'),
        );
    }

    public function saveForm()
    {
        if($_POST['ServiceType'])
        {
            $this->attributes = $_POST['ServiceType'];
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
                FROM  `service_type`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        return parent::beforeSave();
    }
}