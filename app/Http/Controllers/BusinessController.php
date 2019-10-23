<?php

namespace App\Http\Controllers;

use App\Business;
use App\Fine;
use App\FineType;
use App\Termination;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function __construct(Business $business)
    {
    	$this->business = $business;
    }

    public function showApi($id)
    {
        return $this->business->with([
            'applications' => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'inspections' => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'fines' => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'fines.fineType',
            'fees'  => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'fees.feeType',
            'complaints' => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'terminations' => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'licenses' => function($q) {
                $q->orderBy('updated_at', 'desc');
            } ,
            'gradingInspections' => function($q) {
                $q->orderBy('updated_at', 'desc');
            },
            'gradingInspections.gradingFormSingle' => function($q) {
                $q->orderBy('updated_at', 'desc');
            },
        ])->findOrFail($id);
    }

    public function expiringSoonApi(Request $request)
    {
        $query = $this->business->where('expire_at', '>=', Carbon::now());

        if ($request->month) {
            $query = $query->where('expire_at', '<=', Carbon::now()->addMonths($request->month));  
        }

        return $query->orderBy('expire_at', 'desc')->paginate();
        // return $this->business->orderBy('expire_at', 'desc')->paginate();
    }

    public function search(Request $request)
    {
        $businesses = $this->business;

        if ($term = $request->term) {
            $businesses = $businesses->where('name', 'LIKE', '%' . trim($term) . '%')
                    ->orWhere('name_dv', 'LIKE', '%' . trim($term) . '%')
                    ->orWhere('registration_no', 'LIKE', '%' . trim($term) . '%')
                    ->orWhere('phone', 'LIKE', '%' . trim($term) . '%')
                    ->get();
        }

        if ($request->found) {
            return $businesses;
        }

        return $this->business->all();
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.business-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => 'required',
            "name_dv" => 'required',
            "phone" => '',
            "registration_no" => '',
        ]);

        if ($business = $this->business->create([
            "name" => $request->name,
            "name_dv" => $request->name_dv,
            "phone" => $request->phone,
            "registration_no" => $request->registration_no,
        ])) {
            activity()
                ->performedOn($business)
                ->causedBy($request->user())
                ->withProperties($business->toArray())
                ->log('business created');    
        }

        return $business;
    }

    public function edit(Business $business)
    {
        return view('pages.business-edit', compact('business'));
    }

    public function update(Request$request, Business $business)
    {
        $data = $request->validate([
            "name" => 'required',
            "name_dv" => 'required',
            "phone" => '',
            "registration_no" => '',
        ]);

        $business->fill($data);

        if ($business->isDirty()) {
            if ($business->save()) {
                activity()
                    ->performedOn($business)
                    ->causedBy($request->user())
                    ->withProperties($business->toArray())
                    ->log('business created');    
            }
        }

        return redirect()->route('businesses.show', $business->id);
     }

    public function expired(Request $request)
    {
        return $this->business
            ->where('expire_at', '<=', Carbon::now())
            ->orderBy('expire_at', 'desc')->paginate();
    }

    public function fine(Request $request, Business $business)
    {
        $fineType = FineType::findOrFail($request->fine_type_id);
        $fineSlipNumber = $this->getFineSlipNo($request, $business);

        if ($fine = Fine::create([
            'business_id' => $business->id,
            'inspection_id' => null,
            'amount' => ($request->amount) ? $request->amount : $fineType->amount,
            'fined_on' => $request->fined_on,
            'fine_slip_no' => $fineSlipNumber,
            'fine_slip_path' => $this->saveFineSlip($request),
            // 'paid_on' => $request->paid_on,
            // 'is_paid' => ($request->paid_on) ? true : false,
            // 'receipt_no' => $request->receipt_no,
            'remarks' => $request->remarks,
            'fine_type_id' => $fineType->id,
        ])) {
            activity()
               ->performedOn($fine)
               ->causedBy($request->user())
               ->log('fine created for the business');
        }

        return $fine;
    }

    public function saveFineSlip(Request $request)
    {
        if ($path = $request->file('image')->store('/hardcopies/fineslips')) {
            return $path;
        }

        return response()->json([
            'message' => 'unable to upload or save'
        ], 400);
    }


    protected function getFineSlipNo($request, $business)
    {
        if ($request->fine_slip_no) {
            if (Fine::where('fine_slip_no', $request->fine_slip_no)->count()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'fine_slip_no' => ['fine slip number exists.'],
                ]);
            }

            return $request->fine_slip_no;
        }

        return $this->generatedFineSlipNo($business);
    }

    protected function generatedFineSlipNo($business)
    {
        if ($lastFine = Fine::where('business_id', $business->id)->orderBy('id', 'desc')->first()) {
            return 'FS-' . $lastFine->id . $business->id;
        }

        return 'FS-0' . $inspection->business_id;
    }

    public function terminate(Request $request, Business $business)
    {
        if ($request->inspection_id) {
            $inspection = $business->inspections()->findOrFail($request->inspection_id);
            if ($inspection->termination()->count()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                   'message' => ['there is an existing termination for this inspection.'],
                ]);
            }
        }

        $request->validate([
            // 'inspection_id' => 'required',
            'terminated_on' => 'required',
            'reason' => 'required',
        ]);

        \DB::transaction(function() use ($business, $request) {
            $termination = Termination::create([
                'inspection_id' => $request->inspection_id,
                'business_id' => $business->id,
                'terminated_on' => $request->terminated_on,
                'reason' => $this->getTerminateReason($request),
                'remarks' => $request->remarks,
            ]);

            $business->termination_id = $termination->id;
            if ($business->save()) {
                activity()
                    ->performedOn($termination)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['business_id' => $business->id],$termination->toArray())
                    )
                    ->log('business teminated');    
            }
        });

        return $business->load('termination');
    }

    protected function getTerminateReason($request)
    {
        if ($request->reason == 'Other' && !$request->remarks) {
            throw \Illuminate\Validation\ValidationException::withMessages([
               'message' => ['you need to specify reason on remarks when other is selected'],
            ]);
        }

        if (in_array($request->reason, Termination::ALLOWED_REASONS)) {
            return $request->reason;
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
           'message' => ['unknown termination reason'],
        ]);
    }

    public function reopen(Request $request, Business $business)
    {
        $request->validate([
            // 'inspection_id' => 'required',
            'remarks' => 'required',
        ]);

        $termination = Termination::withTrashed()->where('business_id', $business->id)->findOrFail($business->termination_id);
        $remarks = $termination->remarks . ' reopened remarks:' . $request->remarks;

        if ($request->inspection_id) {
            $inspectionId = $business->inspections()->findOrFail($request->inspection_id)->id;
            $remarks = $remarks . ' with inspection id: ' . $inspectionId; 
        } else {
            $inspectionId = null;
        }

        \DB::transaction(function() use ($business, $remarks, $termination, $request) {
            $termination->remarks = $remarks;
            $termination->save();
            
            $business->termination_id = null;
            if ($business->save()) {
                activity()
                    ->performedOn($termination)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['business_id' => $business->id, 'remarks' => $request->remarks])
                    )
                    ->log('reopened closed establishment');    
            }
        });

        return $termination;
    }
}
