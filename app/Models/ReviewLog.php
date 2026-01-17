<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLog extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'review_log';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'actor',
        'role',
        'action',
        'note',
    ];

    /**
     * Get the submission that the review log belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(ThesisSubmission::class);
    }
}
