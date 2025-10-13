<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'program_study';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'fakultas_id',
    ];

    /**
     * Get the faculty that the program study belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
