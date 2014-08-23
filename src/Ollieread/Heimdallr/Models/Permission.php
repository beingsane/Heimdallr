<?php namespace Ollieread\Heimdallr\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $table = 'access_permissions';

    protected $fillable = [
        'name', 'ident', 'description', 'route'
    ];

    public function rights()
    {
        return $this->hasMany('Ollieread\Heimdallr\Models\Right', 'permission_id');
    }

} 