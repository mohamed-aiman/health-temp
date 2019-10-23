<?php


namespace Tests\Feature\Inspection;

use App\Application;
use App\Business;
use App\Inspection;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApplicationProcessedTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * this is done after scheduling an inspection for application
     * @test
     */
    public function can_set_application_status_from_pending_to_processed_if_inspection_is_scheduled()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');

		$business = factory(Business::class)->create();
		$application = factory(Application::class, 'new_food_permit')->create(['business_id' => $business->id, 'status' => 'pending']);
		$inspection = factory(Inspection::class)->create(['application_id' => $application->id]);

	    $response = $this->patchJson("/api/applications/{$application->id}/status/processed");

	    $response->assertOk();
		$this->assertDatabaseHas('applications', [ 'id' => $application->id, 'status' => 'processed']);
	}

	/**
     * @test
     */
    public function cannot_set_application_status_from_pending_to_processed_if_inspection_is_not_scheduled()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');

		$business = factory(Business::class)->create();
		$application = factory(Application::class, 'new_food_permit')->create(['business_id' => $business->id, 'status' => 'pending']);
		// $inspection = factory(Inspection::class)->create(['application_id' => $application->id]);

	    $response = $this->patchJson("/api/applications/{$application->id}/status/processed");

	    $response->assertStatus(422);
		$this->assertDatabaseHas('applications', [ 'id' => $application->id, 'status' => 'pending']);
	}

	/**
     * @test
     */
    public function cannot_set_application_status_to_processed_if_its_not_in_pending_status()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');

		$business = factory(Business::class)->create();
		$states = [
			'draft',
			// 'pending',
			'processed',
			'cancelled'
		];

		$status = $states[array_rand($states)];
		$application = factory(Application::class, 'new_food_permit')->create(['business_id' => $business->id, 'status' => $status]);
		$inspection = factory(Inspection::class)->create(['application_id' => $application->id]);

	    $response = $this->patchJson("/api/applications/{$application->id}/status/processed");

	    $response->assertStatus(422);
		$this->assertDatabaseHas('applications', [ 'id' => $application->id, 'status' => $status]);
	}
}