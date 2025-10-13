<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupervisorAssignment extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'supervisor_assignment';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'pembimbing1_id',
        'pembimbing2_id',
        'ditetapkan_oleh',
        'tanggal',
    ];

    /**
     * Get the submission that the supervisor assignment belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(ThesisSubmission::class);
    }

    /**
     * Get the first supervisor (pembimbing 1) that the supervisor assignment belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor1()
    {
        return $this->belongsTo(Lecturer::class, 'pembimbing1_id');
    }

    /**
     * Get the second supervisor (pembimbing 2) that the supervisor assignment belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor2()
    {
        return $this->belongsTo(Lecturer::class, 'pembimbing2_id');
    }
}
