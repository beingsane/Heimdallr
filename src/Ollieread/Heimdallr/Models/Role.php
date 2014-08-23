<?php namespace Ollieread\Heimdallr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Role extends Model
{

    protected $table = 'access_roles';

    protected $fillable = [
        'name', 'ident', 'description', 'level'
    ];

    public function users()
    {
        return $this->belongsToMany(Config::get('auth.driver'), 'access_user_roles', 'user_id', 'role_id');
    }

    public function rights()
    {
        return $this->hasMany('Ollieread\Heimdallr\Models\Right', 'role_id');
    }

    public function can($resource, $permission = null)
    {
        return $this->rights()->whereHas('resource', function($query2) use($resource)
            {
                $query2->where('ident', $resource);
            })->whereHas('permission', function($query3) use($permission)
            {
                $query3->where('ident', $permission);
            })->count() > 0;
    }

} 