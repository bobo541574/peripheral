<?php

namespace Bobo\Peripheral\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Permission extends Model {
    use HashableId, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'group',
    ];

    protected $casts = [
        'name' => 'json',
    ];
}