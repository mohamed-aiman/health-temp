<?php

namespace App;

use App\Application;

class Document extends Model
{
	protected $guarded = [];
	
    public function applications()
    {
    	return $this->belongsToMany(Application::class);
    }
}
