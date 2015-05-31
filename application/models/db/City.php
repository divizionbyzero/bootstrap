<?php
class City extends CActiveRecord
{
    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'city';
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
        if($_POST['City'])
        {
            $this->attributes = $_POST['City'];
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
                FROM  `city`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        return parent::beforeSave();
    }
}