<?php
class Organization extends CActiveRecord
{
    public $services = array();

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'organization';
    }

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('email', 'email'),
            array('sort_order', 'numerical'),
            array('title, description, phone', 'safe')
        );
    }

    public function saveForm()
    {
        if($_POST['Organization'])
        {
            $this->attributes = $_POST['Organization'];
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
                FROM  `organization`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        return parent::beforeSave();
    }
}