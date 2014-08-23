<?php namespace Ollieread\Heimdallr\Exceptions;

class InvalidRoleException extends \Exception
{

    protected $role;

    public function __construct($role)
    {
        $this->role = $role;

        $this->message = 'User does not have the required role (' . $role . ')';
    }

    public function getRole()
    {
        return $this->role;
    }

} 