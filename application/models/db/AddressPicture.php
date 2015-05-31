<?php
class AddressPicture extends CActiveRecord
{
    const file_dir = 'public/uploads/address';
    const thumb_dir = 'public/uploads/address/thumb';
    const thumb_width = 200;
    const thumb_height = 200;

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'address_picture';
    }

    public function rules()
    {
        return array(
            array('address_id, title', 'required'),
            array('file_name', 'required', 'on'=>'add'),
            array('sort_order, address_id', 'numerical'),
            array('file_name', 'file', 'types'=>'jpg, jpeg, png, gif', 'allowEmpty'=>true),
        );
    }

    public function saveForm()
    {
        if($_POST['AddressPicture'])
        {
            $this->attributes = $_POST['AddressPicture'];
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
                FROM  `address_picture`
                WHERE `address_id`=\''.$this->address_id.'\'
            ')->queryScalar();

            $sort_order = $sort_order ? $sort_order : 0;
            $this->sort_order = ++$sort_order;
        }

        $this->uploadFile();

        return parent::beforeSave();
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