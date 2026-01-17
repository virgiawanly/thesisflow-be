<?php

namespace App\Traits;

use App\Models\Scopes\ProgramStudyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ScopedByProgramStudy
{
  /**
   * Boot the scoped program study.
   */
  protected static function bootScopedByProgramStudy(): void
  {
    // Add global scope for query
    static::addGlobalScope(new ProgramStudyScope);

    // Auto fill program study id on create new model
    static::creating(function (Model $model) {
      if (Auth::check()) {
        $model->prodi_id = Auth::user()->prodi_id;
      }
    });
  }

  /**
   * Disable the program study scope.
   */
  public static function withoutProgramStudyScope(): mixed
  {
    return (new static)->newQueryWithoutScope(new ProgramStudyScope);
  }
}
