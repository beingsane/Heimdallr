<?php namespace Ollieread\Heimdallr\Facades;

use Illuminate\Support\Facades\Facade;

class Heimdallr extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'heimdallr';
    }

} 