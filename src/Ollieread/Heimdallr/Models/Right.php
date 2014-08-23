<?php namespace Ollieread\Heimdallr\Models;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{

    protected $table = 'access_role_rights';

    protected $fillable = [
        'role_id', 'resource_id', 'permission_id'
    ];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('Ollieread\Heimdallr\Models\Role', 'role_id');
    }

    public function resource()
    {
        return $this->belongsTo('Ollieread\Heimdallr\Models\Resource', 'resource_id');
    }

    public function permission()
    {
        return $this->belongsTo('Ollieread\Heimdallr\Models\Permission', 'permission_id');
    }

} 