<?php

namespace App\Http\Controllers;

use App\Application;
use App\Business;
use Illuminate\Http\Request;

class BusinessApplicationController extends Controller
{
    public function __construct(Business $business, Application $application)
    {
        $this->business = $business;
        $this->application = $application;
    }

    // public function create($businessId)
    // {
    //     return view('pages.business-applications-create', compact('businessId'));
    // }
}
