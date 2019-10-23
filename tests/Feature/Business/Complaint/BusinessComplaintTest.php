<?php


namespace Tests\Feature\Business\Complaint;

use App\Application;
use App\Business;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BusinessComplaintTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;


    /**
     * @test
     */
    public function creates_new_business()
    {
		$this->authenticated();
		$this->hasPermission('api.businesses.complaints.store');    	

		$business = factory(Business::class)->create();

		$complaintAt = Carbon::now();

	    $response = $this->postJson("/api/businesses/{$business->id}/complaints", [
			"summary" => "some summary",
			"reference" => 'some reference',
			'complaint_at' => $complaintAt->format('Y-m-d H:i:s'),
	    ]);


	    $response->assertStatus(200);

	    $response->assertJson([
			"id" => $business->id,
			"complaints" => [
		    	[
					"business_id" => $business->id,
					"reference" => "some reference",
					"summary" => "some summary",
					"complaint_at" => $complaintAt->format('Y-m-d H:i:s'),
				]
		    ]
		]);
	}

}