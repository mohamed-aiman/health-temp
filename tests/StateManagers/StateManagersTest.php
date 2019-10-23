<?php

namespace Tests\Feature;

use App\DhivehiReport;
use App\Inspection;
use App\StateManagers\Inspection\InspectionContext;
use App\StateManagers\Report\ReportContext;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StateManagersTest extends TestCase
{

    use DatabaseMigrations;
    use DatabaseTransactions;
    /**
     * @test
     */
    public function inspection_state_machine()
    {
        $model = factory(Inspection::class)->create(['state' => 'created']);
        $inspection = new InspectionContext($model);

        $this->assertEquals($model->state,'created');
        // $inspection->created();
        $inspection->scheduled(); //now the state is filling checklist
        $this->assertEquals($model->state,'scheduled');
        $inspection->ongoing(); //fillingChecklist(); //now the state is filling checklist
        $this->assertEquals($model->state,'ongoing');
        $inspection->completed(); //checklistFilled();  //now the state is checklist filled
        $this->assertEquals($model->state, 'completed');
        $this->assertTrue($inspection->canChangeTo('decision_made'));
        $inspection->decisionMade();
        $this->assertEquals($model->state,'decision_made');
        $inspection->finished();
        $this->assertEquals($model->state,'finished');
        $inspection->closed();
        $this->assertEquals($model->state,'closed');
    }

    /**
     * @test
     */
    public function dhivehi_report_state_machine()
    {
        $model = factory(DhivehiReport::class)->create(['state' => 'generated']);
        $dhivehireport = new ReportContext($model);

        $this->assertEquals($model->state,'generated');
        // $dhivehireport->generated();
        $dhivehireport->prepared();
        $this->assertEquals($model->state,'prepared');
        $dhivehireport->approved();
        $this->assertEquals($model->state,'approved');
        $this->assertTrue($dhivehireport->canChangeTo('handed_over'));
        $dhivehireport->handedOver();
        $this->assertEquals($model->state,'handed_over');
    }
}
