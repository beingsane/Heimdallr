<?php namespace Ollieread\Heimdallr\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Basic user model providing some basic functionality.
 *
 * @package Ollieread\Heimdallr\Models
 */
class User extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('Ollieread\Heimdallr\Models\Role', 'access_user_roles', 'role_id', 'user_id');
    }

    /**
     * To check whether a user has the specified role
     *
     * @param $role
     * @return bool
     */
    public function is($role)
    {
        return $this->whereHas('roles', function($query) use($role)
        {
            $query->where('ident', $role);
        })->count() > 0;
    }

    /**
     * Check whether a user has the supplied permission(s) on the supplied resource(s).
     *
     * Can either password (resource, permission) or an array of key => value associations
     * with the key being the resource, and the value being the permission.
     *
     * @param $resource
     * @param null $permission
     * @return bool
     */
    public function can($resource, $permission = null)
    {
        if(is_array($resource)) {
            // An array of resource => permission has been passed, so we want to make
            // sure the user has all of them.
            return $this->roles()->whereHas('rights', function($query1) use($resource)
            {
                foreach($resource as $key => $value) {
                    $query1->whereHas('resource', function($query2) use($key, $value)
                    {
                        $query2->where('ident', $key)->whereHas('permission', function($query3) use($value)
                        {
                            $query3->where('ident', $value);
                        });
                    });
                }
            })->count() > 0;
        } elseif($permission) {
            // Basic usage, a single resource and permission
            return $this->roles()->whereHas('rights', function($query1) use($resource, $permission)
            {
                $query1->whereHas('resource', function($query2) use($resource, $permission)
                {
                    $query2->where('ident', $resource)->whereHas('permission', function($query3) use($permission)
                    {
                        $query3->where('ident', $permission);
                    });
                });
            })->count() > 0;
        }

        return false;
    }

    /**
     * A nice way to get a list of roles with the key always being the id, and the value
     * being whatever is specified, name/ident are the options.
     *
     * @param string $value
     * @return mixed
     */
    public function listRoles($value = 'name')
    {
        return $this->roles()->lists($value, 'id');
    }

    /**
     * A nice way to get a list of resources with associative permissions. Set the key
     * to be either id, name or ident..name would be somewhat useless.
     *
     * @param string $key
     * @return array
     */
    public function listResources($key = 'ident')
    {
        $rights = $this->roles()->rights()->with('resource', 'permission')->all();
        $list = [];

        foreach($rights as $right) {
            $list[$right->resource->$key][] = $right->permission;
        }

        return $list;
    }

    /**
     * A nice way to return all the rights of a user, again, key is defined as either ident or name,
     * with the value being a further array of resource => $permission.
     *
     * @param string $key
     * @return array
     */
    public function listRights($key = 'ident')
    {
        $roles = $this->roles()->with('right.resource', 'right.permission')->all();
        $list = [];

        foreach($roles as $role) {
            if(!isset($list[$role->$key])) {
                $list[$role->$key] = [];
            }

            foreach($role->rights as $right) {
                $list[$role->$key][$right->resource->$key][] = $right->permission->$key;
            }
        }

        return $list;
    }

} 