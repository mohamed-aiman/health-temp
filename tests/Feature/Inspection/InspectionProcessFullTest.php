<?php


namespace Tests\Feature\Inspection;

use App\Application;
use App\Business;
use App\DhivehiReport;
use App\DhivehiReportNormalFormPoint;
use App\EnglishReport;
use App\Inspection;
use App\NormalCategory;
use App\NormalForm;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class InspectionProcessFullTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function can_schedule_inspection_for_application()
    {
		$this->authenticated();

		$business = factory(Business::class)->create();
		$application = factory(Application::class, 'new_food_permit')->create([
			'business_id' => $business->id,
			"_1registrationNumber" => $business->registration_no,
			'status' => 'pending'
		]);

		$inspection = $this->createApplicationInspection($application);//inspection created
		$this->processApplication($application, $inspection); //inspection scheduled
		$inspection = $this->rescheduleInspection($inspection); //inspection rescheduled

		$inspection = $this->initialVisitBuildForm($inspection);
		//skipped testing http://health.local:406/api/normalforms/1/points
		//check list furan fashan vegen lock kurun
		$this->markAsOngoingInspection($inspection);
		//check list furai nimunee
		$this->markAsChecklistMarkingCompleted($inspection);
		// $this->sendFormBackToEditing($inspection); //works, but commented for now
		$this->generateDhivehiReport($inspection);

	}

	protected function generateDhivehiReport($inspection)
	{
		$this->assertDatabaseHas('inspections', [
			'id' => $inspection->id,
			'english_report_id' => null,
			'dhivehi_report_id' => null,
	    	'state' => 'completed',
	    	'status' => 'created',
	    ]);

	    $this->assertEquals(DhivehiReport::count(), 0);
	    $this->assertEquals(EnglishReport::count(), 0);
	    $response = $this->getJson("/api/inspections/{$inspection->id}/dhivehi/reports");

	    $this->assertEquals(DhivehiReport::count(), 1);
	    $this->assertEquals(EnglishReport::count(), 0);


	    // $this->assertEquals(DhivehiReportNormalFormPoint::count(), 0); //points mark koffa huriyyaa generated report ga hunnanvaane

	}

	protected function sendFormBackToEditing($inspection)
	{
		$response = $this->patchJson("/api/normalforms/{$inspection->normal_form_id}/status/draft");

	    $response->assertOk();
		$this->assertDatabaseHas('inspections', [
			'id' => $inspection->id,
	    	'state' => 'ongoing',
	    	'status' => 'created',
	    ]);

	    $this->assertDatabaseHas('normal_forms', [
			'normal_inspection_id' => $inspection->id,
	    	'status' => 'draft',
	    ]);

	}

	protected function markAsChecklistMarkingCompleted($inspection)
	{
		$response = $this->patchJson("/api/normalforms/{$inspection->normal_form_id}/status/pending");

	    $response->assertOk();
		$this->assertDatabaseHas('inspections', [
			'id' => $inspection->id,
	    	'state' => 'completed',
	    	'status' => 'created',
	    ]);

	    $this->assertDatabaseHas('normal_forms', [
			'normal_inspection_id' => $inspection->id,
	    	'status' => 'pending',
	    ]);
	}

	protected function markAsOngoingInspection($inspection)
	{
		$response = $this->patchJson("/api/inspections/{$inspection->id}/status/ongoing");

	    $response->assertOk();
		$this->assertDatabaseHas('inspections', [
			'id' => $inspection->id,
	    	'state' => 'ongoing',
	    	// 'status' => 'created',
	    ]);

	    $this->assertDatabaseHas('normal_forms', [
			'normal_inspection_id' => $inspection->id,
	    	'status' => 'draft',
	    ]);
	}

	protected function initialVisitBuildForm($inspection)
	{
	    $this->assertNull($inspection->normal_form_id);

	    $response = $this->getJson("/api/normalinspections/{$inspection->id}/normalforms");

	    $inspection = $inspection->fresh();
	    
	    $response->assertOk();
	    $this->assertNotNull($inspection->normal_form_id);
		$this->assertDatabaseHas('inspections', [
			'id' => $inspection->id,
	    	'state' => 'started',
	    	'status' => 'created',
	    ]);
	    $this->assertDatabaseHas('normal_forms', [
			'normal_inspection_id' => $inspection->id,
	    	'status' => 'draft',
	    ]);

	    return $inspection;
	}

	protected function createApplicationInspection($application)
	{
		$inspectionAt = Carbon::now()->addDays(20);

	    $response = $this->postJson("/api/applications/{$application->id}/inspections", [
	    	'inspection_at' => $inspectionAt->format('Y-m-d H:i:s')
	    ]);

	    $response->assertOk();
	    $this->assertDatabaseHas('inspections', [
	    	'application_id' => $application->id,
	    	'inspection_at' => $inspectionAt,
	    	'state' => 'created',
	    	'status' => 'created',
	    ]);
	    $this->assertEquals($application->inspections->count(), 1);

	    return $inspection = $application->inspections()->first();
	}

	protected function processApplication($application, $inspection)
	{
	    $response = $this->patchJson("/api/applications/{$application->id}/status/processed", [
	    	'inspection_id' => $inspection->id
	    ]);


	    $response->assertOk();
	    $this->assertDatabaseHas('inspections', [
	    	'id' => $inspection->id,
	    	'application_id' => $application->id,
	    	'state' => 'scheduled',
	    	'status' => 'created',
	    ]);
	    $this->assertDatabaseHas('applications', [
	    	'id' => $application->id,
	    	'status' => 'processed',
	    ]);
	}

	protected function rescheduleInspection($inspection)
	{
		$inspectionAt = Carbon::now()->addDays(30);

	    $response = $this->patchJson("/api/inspections/{$inspection->id}", [
	    	'inspection_at' => $inspectionAt->format('Y-m-d H:i:s'),
			'reason' => 'some reason...',
			'remarks' => 'some remarks'
	    ]);

	    $response->assertOk();
	    $this->assertDatabaseHas('inspections', [
	    	'id' => $inspection->id,
	    	// 'inspection_at' => $inspectionAt,
	    	'state' => 'scheduled',
	    	// 'status' => 'created',
			'reason' => 'some reason...',
			'remarks' => 'some remarks'
	    ]);

	    return $inspection->fresh();
	}
}