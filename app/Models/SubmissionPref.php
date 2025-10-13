<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionPref extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'submission_pref';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'lecturer_id',
        'urutan',
    ];

    /**
     * Get the submission that the submission pref belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(ThesisSubmission::class);
    }

    /**
     * Get the lecturer that the submission pref belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
