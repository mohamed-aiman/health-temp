<?php
namespace App\StateManagers;

use App\DhivehiReport;
use App\Inspection;
use App\StateManagers\Inspection\InspectionContext;
use App\StateManagers\Report\ReportContext;

class Test
{
    public function testInspection()
    {
        $model = factory(Inspection::class)->create(['state' => 'created']);
        $inspection = new InspectionContext($model);

	    // $inspection->created();
        $inspection->scheduled(); //now the state is filling checklist
        $inspection->ongoing(); //fillingChecklist(); //now the state is filling checklist
        $inspection->completed(); //checklistFilled();  //now the state is checklist filled
        // dd($inspection->canChangeTo('decision_made'));
		$inspection->decisionMade();
		$inspection->finished();
		$inspection->closed();
    }

    public function testDhivehiReport()
    {
        $model = factory(DhivehiReport::class)->create(['state' => 'generated']);
        $dhivehireport = new ReportContext($model);

        // $dhivehireport->generated();
        $dhivehireport->prepared();
        $dhivehireport->approved();
        dd($dhivehireport->canChangeTo('handed_over'));
        $dhivehireport->handedOver();
    }
}
