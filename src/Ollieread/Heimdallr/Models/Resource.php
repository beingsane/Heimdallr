<?php namespace Ollieread\Heimdallr\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

    protected $table = 'access_resources';

    protected $fillable = [
        'name', 'ident', 'description', 'route'
    ];

    public function rights()
    {
        return $this->hasMany('Ollieread\Heimdallr\Models\Right', 'resource_id');
    }

} 