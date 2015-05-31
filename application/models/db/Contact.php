<?php
class Contact extends CActiveRecord
{
    public  $type;

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'contact';
    }

    public function rules()
    {
        return array(
            array('contact_type_id, address_id, contact', 'required'),
            array('sort_order', 'numerical'),
        );
    }

    public function saveForm()
    {
        if($_POST['Contact'])
        {
            $this->attributes = $_POST['Contact'];
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
                FROM  `contact`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->type = ContactType::model()->findByPk($this->contact_type_id)->name;
        return parent::afterFind();
    }
}