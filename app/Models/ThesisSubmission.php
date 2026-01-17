<?php

namespace App\Models;

class ThesisSubmission extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'thesis_submission';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'semester',
        'sumber',
        'topic_offer_id',
        'topik_kategori',
        'judul',
        'abstrak',
        'keywords',
        'status',
    ];

    /**
     * Get the student that the thesis submission belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the topic offer that the thesis submission belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topicOffer()
    {
        return $this->belongsTo(TopicOffer::class);
    }

    /**
     * Get the submission prefs for the thesis submission.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissionPrefs()
    {
        return $this->hasMany(SubmissionPref::class);
    }

    /**
     * Get the eligibility snapshots for the thesis submission.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eligibilitySnapshots()
    {
        return $this->hasMany(EligibilitySnapshot::class);
    }
}
