<?php

namespace App\Models;

use App\Traits\ScopedByProgramStudy;

class ThesisPeriod extends BaseModel
{
    use ScopedByProgramStudy;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'thesis_period';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'prodi_id',
        'semester',
        'stage',
        'start_at',
        'end_at',
    ];
}
