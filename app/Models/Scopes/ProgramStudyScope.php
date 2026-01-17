<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ProgramStudyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $tableName = $model->getTable();

        if (Auth::check()) {
            $prodiId = Auth::user()->prodi_id;
        } else {
            $prodiId = $model->prodi_id;
        }

        $builder->where($tableName . '.' . ($model->prodiIdColumn ?? 'prodi_id'), $prodiId);
    }
}
