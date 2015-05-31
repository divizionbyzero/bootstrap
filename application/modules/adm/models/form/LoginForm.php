<?php
class LoginForm extends CFormModel
{
    public $email;
    public $password;
    public $remember_me = false;

    private $_identity;

    public function rules()
    {
        $emails_list = Yii::app()->db->createCommand('
            SELECT `email` FROM `app_user`
        ')->queryColumn();

        return array(
            array('email, password', 'required'),
            array('email', 'email'),
            array('email', 'in', 'range' => $emails_list, 'message' => 'entered email address not exist'),
            array('remember_me', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function authenticate($attribute, $params)
    {
        $this->_identity = new UserIdentity($this->email, $this->password);
        $this->_identity->authenticate();

        if ($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
            $duration = $this->remember_me ? 3600 * 24 * 30 : 0;
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } elseif ($this->_identity->errorCode == CUserIdentity::ERROR_PASSWORD_INVALID) {
            $this->addError('password', 'Password incorrect');
            return false;
        }
    }
}