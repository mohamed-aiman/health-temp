<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;

class BusinessTerminationController extends Controller
{
    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function show(Business $business, $terminationId)
    {
    	//just for permission sake
    }
}
