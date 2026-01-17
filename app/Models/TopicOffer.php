<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class TopicOffer extends BaseModel
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
     * The attributes that are searchable in the query.
     *
     * @var array<int, string>
     */
    protected $searchables = [
        'judul',
        'kuota',
    ];

    /**
     * The columns that are sortable in the query.
     *
     * @var array<int, string>
     */
    protected $sortableColumns = [
        'judul',
        'kuota',
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

    /**
     * Get the submissions for the topic offer.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(ThesisSubmission::class, 'topic_offer_id');
    }

    /**
     * Scope a query to filter topic offers by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filterStatus(Builder $query, string $value)
    {
        return $query->where('status', $value);
    }
}
