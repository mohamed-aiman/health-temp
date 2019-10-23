<?php


namespace Tests\Feature\DhivehiReport;

use App\Application;
use App\Business;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BusinessStoreTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;


    /**
     * @test
     */
    public function creates_new_business()
    {
		$this->authenticated();
		$this->hasPermission('applications.businesses.store');    	

		factory(Application::class)->create([
			'id' => 22,
			'business_id' => null
		]);

	    $response = $this->postJson('/api/applications/22/businesses', [
			"name" => "Business Name 3885 ghfg",
			"name_dv" => 'ކޮންމެސް ދިވެހި ނަމެއް',
			"phone" => "64685741",
			"registration_no" => "REG1234j"
	    ]);

	    $this->assertDatabaseHas('businesses', [
	    	"id" => 1,
			"name" => "Business Name 3885 ghfg",
			"name_dv" => 'ކޮންމެސް ދިވެހި ނަމެއް',
			"phone" => "64685741",
			"registration_no" => "REG1234j"
	    ]);

	    $this->assertDatabaseHas('applications', [
	    	"id" => 22,
			"business_id" => 1
	    ]);

	    $response->assertStatus(200);

	  //   $response->assertJson([
			// "name" => "Business Name 3885 ghfg",
			// "name_dv" => 'ކޮންމެސް ދިވެހި ނަމެއް',
			// "phone" => "64685741",
			// "registration_no" => "REG1234j"
	  //   ]);
	}

	/**
     * @test
     */
    public function does_not_create_new_business_if_application_attached_to_a_business_already()
    {
		$this->authenticated();
		$this->hasPermission('applications.businesses.store');    	

		factory(Business::class)->create([
			'id' => 55
		]);

		factory(Application::class)->create([
			'id' => 22,
			'business_id' => 55
		]);

	    $response = $this->postJson('/api/applications/22/businesses', [
			"name" => "Business Name 3885 ghfg",
			"name_dv" => 'ކޮންމެސް ދިވެހި ނަމެއް',
			"phone" => "64685741",
			"registration_no" => "REG1234j"
	    ]);

	    $this->assertDatabaseMissing('businesses', [
			"name" => "Business Name 3885 ghfg",
			"name_dv" => 'ކޮންމެސް ދިވެހި ނަމެއް',
			"phone" => "64685741",
			"registration_no" => "REG1234j"
	    ]);

	    $this->assertDatabaseHas('applications', [
	    	"id" => 22,
			"business_id" => 55
	    ]);

	    $response->assertStatus(200);

	  //   $response->assertJson([
			// "name" => "Business Name 3885 ghfg",
			// "name_dv" => 'ކޮންމެސް ދިވެހި ނަމެއް',
			// "phone" => "64685741",
			// "registration_no" => "REG1234j"
	  //   ]);
	}

}