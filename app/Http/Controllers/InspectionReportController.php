<?php

namespace App\Http\Controllers;

use App\Inspection;
use Illuminate\Http\Request;

class InspectionReportController extends Controller
{
	public function __construct(Inspection $inspection)
    {
        $this->inspection = $inspection;
        // $this->report = $report;
    }

    public function pendingReports()
    {
    	return view('pages.inspections-pending-reports');	
    }

    public function pendingReportsApi()
    {
		return $this->inspection
	    	->with('normalForm')
	    	->with('dhivehiReport')
	    	->with('englishReport')
	    	->where(function($query){
		    	$query->whereHas('englishReport', function($q) {
		    		$q->where('status', '=', 'pending');
		    	})
		    	->orWhereHas('dhivehiReport', function($q) {
		    		$q->where('status', '=', 'pending');
		    	});
	    	})
	    	->whereHas('normalForm', function ($q) {
	    		$q->where('normal_forms.status', '=', 'processed');
	    	})
	    	->whereNotNull('normal_form_id')
			->get()
	    	;

    	// dd($reports->toSql());
    }

    public function processedReports()
    {
    	return view('pages.inspections-processed-reports');	
    }

    public function processedReportsApi()
    {
		return $this->inspection
	    	->with('normalForm')
	    	->with('dhivehiReport')
	    	->with('englishReport')
	    	->where(function($query){
		    	$query->whereHas('englishReport', function($q) {
		    		$q->whereIn('status', ['processed', 'issued']);
		    	})
		    	->orWhereHas('dhivehiReport', function($q) {
		    		$q->whereIn('status', ['processed', 'issued']);
		    	});
	    	})
	    	->whereHas('normalForm', function ($q) {
	    		$q->where('normal_forms.status', '=', 'processed');
	    	})
	    	->whereNotNull('normal_form_id')
			->get()
	    	;

    	// dd($reports->toSql());
    }
}
