<?php

namespace App\Models;

class Student extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'student';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'nrp',
        'nama',
        'prodi_id',
        'fakultas_id',
        'status_akademik',
        'status_keuangan',
        'total_sks',
        'ipk',
        'angkatan',
    ];

    /**
     * Get the program study that the student belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class);
    }

    /**
     * Get the faculty that the student belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
