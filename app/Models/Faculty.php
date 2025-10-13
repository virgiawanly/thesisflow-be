<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'faculty';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
    ];

    /**
     * Get the program studies for the faculty.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programStudies()
    {
        return $this->hasMany(ProgramStudy::class);
    }
}
