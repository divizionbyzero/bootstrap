<?php
class Service extends CActiveRecord
{
    public $service_type;
    public $organization;
    public $addresses = array();

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'service';
    }

    public function rules()
    {
        return array(
            array('organization_id, service_type_id, title', 'required'),
            array('cost', 'numerical', 'message'=>'Стоимость должна быть числом. В качестве разделителя допускается точка.'),
            array('description, rating', 'safe')
        );
    }

    public function saveForm()
    {
        if($_POST['Service'])
        {
            $this->attributes = $_POST['Service'];
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
                FROM  `service`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->service_type = ServiceType::model()->findByPk($this->service_type_id)->name;
        $this->organization = Organization::model()->findByPk($this->organization_id)->name;

        $this->addresses = Address::model()->findAll(array(
            'condition'=>'service_id=:service_id',
            'params'=>array(':service_id'=>$this->service_id),
            'order'=>'sort_order'
        ));

        return parent::afterFind();
    }
}