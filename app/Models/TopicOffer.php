<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicOffer extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'topic_offer';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'lecturer_id',
        'judul',
        'deskripsi',
        'keywords',
        'prasyarat',
        'kuota',
        'bidang_id',
        'status',
    ];

    /**
     * Get the lecturer that the topic offer belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    /**
     * Get the field taxonomy that the topic offer belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo(FieldTaxonomy::class, 'bidang_id');
    }
}
