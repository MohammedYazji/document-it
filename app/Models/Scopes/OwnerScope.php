<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class OwnerScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user->type, ['admin', 'super-admin'])) {
                return;
            }

            if (request()->is('dashboard*')) {
                $builder->where('user_id', $user->id);
            }
        }
    }
}
