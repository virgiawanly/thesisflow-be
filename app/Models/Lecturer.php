<?php

namespace App\Models;

class Lecturer extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lecturer';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'nidn',
        'nama',
        'prodi_id',
        'fakultas_id',
        'email',
        'aktif',
    ];

    /**
     * Get the program study that the lecturer belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class);
    }

    /**
     * Get the faculty that the lecturer belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the topic offers for the lecturer.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topicOffers()
    {
        return $this->hasMany(TopicOffer::class);
    }
}
