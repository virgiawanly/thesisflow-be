<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class FieldTaxonomy extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'field_taxonomy';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'parent_id',
    ];

    /**
     * The attributes that are searchable.
     * 
     * @var array<int, string>
     */
    protected $searchables = [
        'nama',
    ];

    /**
     * The columns that are sortable in the query.
     *
     * @var array<int, string>
     */
    protected $sortableColumns = [
        'id',
        'nama',
        'parent_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Filter the parent id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function filterParentId(Builder $query, mixed $value)
    {
        return $query->where('parent_id', $value === "-" ? null : $value);
    }

    /**
     * Search the parent.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function searchParent(Builder $query, mixed $value)
    {
        return $query->whereHas('parent', function ($query) use ($value) {
            $query->where('nama', 'LIKE', "%{$value}%");
        });
    }

    /**
     * Get the parent field taxonomy.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(FieldTaxonomy::class);
    }

    /**
     * Get the children field taxonomies.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(FieldTaxonomy::class);
    }
}
