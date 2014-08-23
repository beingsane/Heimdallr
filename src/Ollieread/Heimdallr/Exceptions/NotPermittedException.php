<?php namespace Ollieread\Heimdallr\Exceptions;

class NotPermittedException extends \Exception
{

    protected $resource;

    protected $permission;

    public function __construct($resource, $permission)
    {
        $this->resource = $resource;
        $this->permission = $permission;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getPermission()
    {
        return $this->permission;
    }

} 