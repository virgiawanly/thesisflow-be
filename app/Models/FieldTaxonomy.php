<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldTaxonomy extends Model
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
