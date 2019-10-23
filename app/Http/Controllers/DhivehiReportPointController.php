<?php

namespace App\Http\Controllers;

use App\DhivehiReport;
use App\DhivehiReportNormalFormPoint;
use App\NormalFormPoint;
use Illuminate\Http\Request;

class DhivehiReportPointController extends Controller
{
    public function __construct(DhivehiReport $report, DhivehiReportNormalFormPoint $point)
    {
        $this->report = $report;
        $this->point = $point;
    }

    public function index(Request $request, DhivehiReport $dhivehiReport)
    {
        if ($request->type) {
            return $this->point->where('dhivehi_report_id', $dhivehiReport->id)->where('code', $request->type)->get();
        }

        return $dhivehiReport->points;
    }

    public function store(Request $request, DhivehiReport $dhivehiReport)
    {
        check_is_inspector($dhivehiReport->inspection);

        if (!$this->isEditable($dhivehiReport)) {
            return $this->notEditableResponse();
        };

        if ($point = $this->point->create([
            'dhivehi_report_id' => $dhivehiReport->id,
            'normal_form_point_id' => null,
            'no' => $request->no,
            'point_no' => $request->point_no,
            'code' => $request->code,
            'violation' => $request->violation,
            'recommendation' => $request->recommendation,
        ])) {
            activity()
                ->performedOn($point)
                ->causedBy($request->user())
                ->withProperties($point->toArray())
                ->log('created a dhivehi report point');
        }
    }

    public function update(Request $request, DhivehiReport $dhivehiReport, $pointId)
    {
        check_is_inspector($dhivehiReport->inspection);

        $point = $this->point->where('dhivehi_report_id', $dhivehiReport->id)->findOrFail($pointId);

        $point->fill($request->all());

        if ($point->isDirty()) {
            if ($point->save()) {
                activity()
                    ->performedOn($point)
                    ->causedBy($request->user())
                    ->withProperties($point->toArray())
                    ->log('updated dhivehi report point');
            }
        }

        return $point->fresh();
    }

    protected function isEditable(DhivehiReport $dhivehiReport)
    {
        return ($dhivehiReport->status == 'draft') ? true : false;
    }

    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'report should be in draft state.'
        ], 422);
    }


    public function destroy(Request $request, DhivehiReport $dhivehiReport, $pointId)
    {
        check_is_inspector($dhivehiReport->inspection);

        if ($this->isEditable($dhivehiReport)) {
            $point = $this->point->where('dhivehi_report_id', $dhivehiReport->id)->findOrFail($pointId);
            $logModel = $point;
            if ($point->delete()) {
                activity()
                    ->performedOn($logModel)
                    ->causedBy($request->user())
                    ->log('deleted dhivehi report point');
            }
        } else {
            return $this->notEditableResponse();
        }
    }
}
