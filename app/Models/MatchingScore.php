<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchingScore extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'matching_score';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'lecturer_id',
        'skor',
        'detail_json',
    ];

    /**
     * Get the submission that the matching score belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(ThesisSubmission::class);
    }

    /**
     * Get the lecturer that the matching score belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
