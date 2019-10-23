<?php

namespace App;

use App\Inspection;
use App\NormalForm;
use App\User;
// 

class NormalInspection extends Inspection
{
	protected $table = 'inspections';

    public function normalForm()
    {
        return $this->belongsTo(NormalForm::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }


    // public function followUpInspection()
    // {
    //     return $this->belongsTo(Inspection::class, 'follow_up_id');
    // }
}
