<?php

namespace Bobo\Peripheral\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRole {
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function canAccess($permission): bool
    {   
        $role = $this->role;

        return $role ? $role->canAccess($permission) : false;
    }
}