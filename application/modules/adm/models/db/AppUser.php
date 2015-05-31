<?php
class AppUser extends CActiveRecord
{
    const file_dir = 'public/uploads/user';
    const thumb_dir = 'public/uploads/user/thumb';
    const thumb_width = 200;
    const thumb_height = 200;

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function tableName()
    {
        return 'app_user';
    }

    public function rules()
    {
        return array(
            array('email, role', 'required'),
            array('password', 'required', 'on' => 'add'),
            array('is_active', 'boolean'),
            array('photo', 'file', 'types'=>'jpg, jpeg, png, gif', 'allowEmpty'=>true),
            array('first_name, last_name, nickname', 'safe'),
        );
    }

    public function saveForm()
    {
        if (isset($_POST['AppUser']) && count($_POST['AppUser'])) {
            $this->attributes = $_POST['AppUser'];
            if ($this->validate()) {
                $this->save();
                return true;
            }
        }
        return false;
    }

    protected function beforeSave()
    {
        $new_password = trim($_POST['AppUser']['password']);
        if ($this->isNewRecord || !empty($new_password)) {
            $this->password = crypt($new_password, $new_password);
        }

        $this->uploadFile();

        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        if(is_file(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->photo))
            unlink(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->photo);
        if(is_file(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$this->photo))
            unlink(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$this->photo);

        return parent::beforeDelete();
    }

    private function uploadFile()
    {
        $file = CUploadedFile::getInstance($this, 'photo');

        if($file)
        {   $old_file = $this->photo;

            $this->photo = AppHelper::umd().'_'.AppHelper::clearFileName($file);
            if($file->saveAs(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->photo))
            {
                $thumb = new Iwi(Yii::getPathOfAlias('webroot').'/'.self::file_dir.'/'.$this->photo);
                $thumb->adaptive(self::thumb_width, self::thumb_height)->crop(self::thumb_width, self::thumb_height)->save(Yii::getPathOfAlias('webroot').'/'.self::thumb_dir.'/'.$this->photo);
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