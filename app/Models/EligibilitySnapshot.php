<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EligibilitySnapshot extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'eligibility_snapshot';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'total_sks',
        'ipk',
        'status_akademik',
        'status_keuangan',
        'prasyarat_ok',
    ];

    /**
     * Get the submission that the eligibility snapshot belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(ThesisSubmission::class);
    }
}
