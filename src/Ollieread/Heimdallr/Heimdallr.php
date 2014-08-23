<?php namespace Ollieread\Heimdallr;

use Illuminate\Support\Facades\Auth;
use Ollieread\Heimdallr\Exceptions\InvalidRoleException;
use Ollieread\Heimdallr\Exceptions\NotPermittedException;
use Ollieread\Heimdallr\Models\User;

/**
 * Class Heimdallr
 * @package Ollieread\Heimdallr
 */
class Heimdallr
{

    /**
     * @param $role
     * @param bool $exception
     * @return bool
     * @throws Exceptions\InvalidRoleException
     */
    public function is($role, $exception = false)
    {
        if(Auth::check()) {
            $user = Auth::user();

            if($user instanceof User) {
                $is = $user->is($role);

                if(!$exception) {
                    return $is;
                } elseif(!$is) {
                    throw new InvalidRoleException($role);
                }
            }
        }

        return false;
    }

    /**
     * @param $resource
     * @param null $permission
     * @param bool $exception
     * @return bool
     * @throws Exceptions\NotPermittedException
     */
    public function can($resource, $permission = null, $exception = false)
    {
        if(Auth::check()) {
            $user = Auth::user();

            if($user instanceof User) {
                $can = $user->can($resource, $permission);

                if(!$exception) {
                    return $can;
                } elseif(!$can) {
                    throw new NotPermittedException($resource, $permission);
                }
            }
        }

        return false;
    }

} 