<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturerQuota extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lecturer_quota';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'lecturer_id',
        'semester',
        'kuota_max',
    ];

    /**
     * Get the lecturer that the lecturer quota belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
