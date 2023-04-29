<?php

namespace Bobo\Peripheral\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Role extends Model {
    use HashableId, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'level',
        'group',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'json'
    ];
}