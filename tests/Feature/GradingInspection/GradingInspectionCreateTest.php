<?php


namespace Tests\Feature\GradingInspection;

use App\Application;
use App\Business;
use App\License;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GradingInspectionCreateTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

	/**
	 * @test
	 */
	public function schedule_new_grading_inspection()
	{
		$this->authenticated();

		$activeLicense = factory(License::class)->create(['id' => 11]);
		$activeApplication = factory(Application::class)->create(['id' => 44]);
		$business = factory(Business::class)->create([
			'id' => 33,
			'active_application_id' => 44,
			'license_id' => 11,
		]);
		// \Log::info('after this...............................................................................................');
		// dd($business->activeApplication);

		$response = $this->postJson('api/businesses/33/gradinginspections', [
			"inspection_at" => '2019-2-7 1:04:00',
			"reason" => "grading"
		]);

		$response->isOk();

		$this->assertDatabaseHas('grading_inspections', [
	        'business_id' => 33,
	        'inspection_at' => '2019-2-7 1:04:00',
	        'status' => 'scheduled',
		]);

		$this->assertDatabaseHas('grading_forms', [
            'place_name' => $business->name_dv,
            'food_registration_no' => $activeLicense->license_no,
            'owner' => $activeApplication->_2name . '/' . $activeApplication->_3address,
            'inspection_date' => '2019-2-7 1:04:00',
            'permit_limit' => '',
            'phone' => $business->phone,
            'information_provider' => '',
            // 'grading_inspection_id' => $inspection->id,
            'reason' => 'grading'
		]);


		// dd($response->json());
		// $response->assertStatus(201);
	}

}