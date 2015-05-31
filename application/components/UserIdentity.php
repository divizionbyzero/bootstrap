<?php
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $user = AppUser::model()->findByAttributes(array('email' => $this->username));

        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($user->password != crypt($this->password, $this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->id_user;
            $this->setState('first_name', $user->first_name);
            $this->setState('last_name', $user->last_name);
            $this->setState('email', $user->email);
            $this->setState('role', $user->role);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}