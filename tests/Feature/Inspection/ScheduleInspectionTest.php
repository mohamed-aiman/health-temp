<?php


namespace Tests\Feature\Inspection;

use App\Application;
use App\Business;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InspectionCreateTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function can_schedule_inspection_for_application()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');

		$business = factory(Business::class)->create();
		$application = factory(Application::class, 'new_food_permit')->create([
			'business_id' => $business->id,
			"_1registrationNumber" => $business->registration_no,
		]);
		$inspectionAt = Carbon::now()->addDays(20);

	    $response = $this->postJson("/api/applications/{$application->id}/inspections", [
	    	'inspection_at' => $inspectionAt->format('Y-m-d H:i:s')
	    ]);

	    $this->assertDatabaseHas('inspections', [
	    	'application_id' => $application->id,
	    	'inspection_at' => $inspectionAt
	    ]);

	    $response->assertOk();
	}
}