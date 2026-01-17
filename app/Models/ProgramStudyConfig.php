<?php

namespace App\Models;

class ProgramStudyConfig extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'program_study_config';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'prodi_id',
        'submission_min_sks',
        'submission_require_financial_clear',
    ];
}
