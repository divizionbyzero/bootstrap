<?php
class Address extends CActiveRecord
{
    public $city;
    public $area;
    public $contacts = array();
    public $pictures = array();

    const file_dir = 'public/uploads/address/street';
    const thumb_dir = 'public/uploads/address/street/thumb';
    const thumb_width = 200;
    const thumb_height = 200;

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'address';
    }

    public function rules()
    {
        return array(
            array('service_id', 'required', 'message'=>'Пожалуйста, выберите услугу'),
            array('city_id', 'required', 'message'=>'Пожалуйста, выберите город'),
            array('area_id', 'required', 'message'=>'Пожалуйста, выберите район'),
            array('title', 'required', 'message'=>'Пожалуйста, введите заголовок'),
            array('address', 'required', 'message'=>'Пожалуйста, введите адресс'),
            array('map_lat, map_lng', 'required', 'message'=>'Пожалуйста, выберите место на карте'),
            array('service_id, city_id, area_id, sort_order', 'numerical')
        );
    }

    public function saveForm()
    {
        if($_POST['Address'])
        {
            $this->attributes = $_POST['Address'];
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
                FROM  `address`
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        $this->uploadFile();

        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->city = City::model()->findByPk($this->city_id)->name;
        $this->area = Area::model()->findByPk($this->area_id)->name;
        $this->contacts = Contact::model()->findAll(array(
            'condition'=>'address_id=:address_id',
            'params'=>array(':address_id'=>$this->address_id),
            'order'=>'sort_order'
        ));
        $this->pictures = AddressPicture::model()->findAll(array(
            'condition'=>'address_id=:address_id',
            'params'=>array(':address_id'=>$this->address_id),
            'order'=>'sort_order'
        ));
        return parent::afterFind();
    }

    protected function beforeDelete()
    {
        if(is_file(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->file_name))
            unlink(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->file_name);
        if(is_file(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$this->file_name))
            unlink(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$this->file_name);

        return parent::beforeDelete();
    }

    private function uploadFile()
    {
        $file = CUploadedFile::getInstance($this, 'file_name');

        if($file)
        {
            $old_file = $this->file_name;

            $this->file_name = AppHelper::umd().'_'.AppHelper::replaceSEO($file, 1);
            if($file->saveAs(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->file_name))
            {
                $thumb = new Iwi(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->file_name);
                $thumb->adaptive(self::thumb_width, self::thumb_height)->crop(self::thumb_width, self::thumb_height)->save(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$this->file_name);
                return true;
            }

            if(is_file(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$old_file))
                unlink(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$old_file);
            if(is_file(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$old_file))
                unlink(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$old_file);
        }

        return false;
    }
}