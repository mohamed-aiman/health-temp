<?php

namespace App;

use App\Inspection;


class EnglishReport extends Model
{
    protected $guarded = [];

    protected $table = 'english_reports';

    protected $appends = [
        "issued_by_name",
    ];


    public function inspection()
    {
    	return $this->hasOne(Inspection::class);
    }

    // public function inspectionBelongsTo()
    // {
    // 	return $this->belongsTo(Inspection::class);
    // }
    
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }


    public function getissuedByNameAttribute()
    {
        if ($user = $this->issuedBy) {
            return $user->name;
        }

        return null;
    }
}
