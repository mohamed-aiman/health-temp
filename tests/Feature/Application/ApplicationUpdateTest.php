<?php


namespace Tests\Feature\DhivehiReport;

use App\Application;
use App\Business;
use App\DhivehiReport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApplicationUpdateTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function updates_new_food_registration_application()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');	

		$application = factory(Application::class, 'new_food_permit')->create();
    	$data = array_replace($this->defaultRequestData(), [
	    	"_1tobaccoOrFood" => "2",
	    	"_1applicationType" => "1",
	    	"_1toRegisterPlace" => true,
	    	"_1toRenewLicense" => false,
	    	"_1registerPlace" => "1",
	    	"_1renewLicense" => "1",
    	]);
    	$expected = array_replace($this->defaultExpected(), [
			"business_id" => null,
			"_1tobaccoOrFood" => "2",
	    	"_1applicationType" => "1",
			"_1toRegisterPlace" => true,
			"_1toRenewLicense" => false,
			"_1registerPlace" => "1",
			"_1renewLicense" => null,
			"permit_type" => "Food",
			"register_or_renew" => "New Registration",
    	]);

	    $response = $this->patchJson("/api/applications/{$application->id}", $data);

	    $response->assertJson($expected);
	    $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function updates_new_food_registration_business_attached_application()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');	

		$business = factory(Business::class)->create();
		$application = factory(Application::class, 'new_food_permit')->create([
			'business_id' => $business->id]);

    	$data = array_replace($this->defaultRequestData(), [
	    	"_1tobaccoOrFood" => "2",
	    	"_1applicationType" => "1",
	    	"_1toRegisterPlace" => true,
	    	"_1toRenewLicense" => false,
	    	"_1registerPlace" => "1",
	    	"_1renewLicense" => "1",
    	]);
    	$expected = array_replace($this->defaultExpected(), [
			"business_id" => $business->id,
			"_1tobaccoOrFood" => "2",
	    	"_1applicationType" => "1",
			"_1toRegisterPlace" => true,
			"_1toRenewLicense" => false,
			"_1registerPlace" => "1",
			"_1renewLicense" => null,
			"permit_type" => "Food",
			"register_or_renew" => "New Registration",
    	]);

	    $response = $this->patchJson("/api/applications/{$application->id}", $data);

	    $response->assertJson($expected);
	    $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function updates_renew_food_registration_application()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');    	
		$business = factory(Business::class)->create();
		$application = factory(Application::class, 'new_food_permit')->create([
			'business_id' => $business->id]);
    	$data = array_replace($this->defaultRequestData(), [
	    	"_1tobaccoOrFood" => "2",
	    	"_1applicationType" => "2",
	    	"_1toRegisterPlace" => false,
	    	"_1toRenewLicense" => true,
	    	"_1registerPlace" => "1",
	    	"_1renewLicense" => "1",
    	]);

    	$expected = array_replace($this->defaultExpected(), [
			"business_id" => $business->id,
			"_1tobaccoOrFood" => "2",
	    	"_1applicationType" => "2",
			"_1toRegisterPlace" => false,
			"_1toRenewLicense" => true,
			"_1registerPlace" => null,
			"_1renewLicense" => "1",
			"permit_type" => "Food",
			"register_or_renew" => "Renew License",
    	]);
	    $response = $this->patchJson("/api/applications/{$application->id}", $data);

	    $response->assertJson($expected);

		$this->assertDatabaseHas('applications', [
			'id' => $application->id,
			'business_id' => $business->id,
			'status' => 'draft',
		]);
	    
	    $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function throws_validation_error_if_trying_to_update_non_draft_application()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');    
		$states = [
			// 'draft',
			'pending',
			'processed',
			'cancelled'
		];
		$application = factory(Application::class, 'new_food_permit')->create(['status' => $states[array_rand($states)]]);	
		$data = array_replace($this->defaultRequestData(), [
	    	"_1tobaccoOrFood" => "1",
	    	"_1applicationType" => "1",
	    	"_1toRegisterPlace" => true,
	    	"_1toRenewLicense" => false,
	    	"_1registerPlace" => "1",
	    	"_1renewLicense" => "1",
    	]);

	    $response = $this->patchJson("/api/applications/{$application->id}", $data);
	    
	    $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function updates_new_tobacco_registration_application()
    {
		$this->authenticated();
		$this->hasPermission('applications.update');
		$registrationNo = 'BREG12765';
		$business = factory(Business::class)->create(['registration_no' => $registrationNo]);
		$application = factory(Application::class, 'new_tobacco_permit')->create([
			'business_id' => $business->id,
			"_1registrationNumber" => 'OLD',
		]);

		$data = array_replace($this->defaultRequestData(), [
			"business_id" => $business->id,
			"_1registrationNumber" => $registrationNo,
	    	"_1tobaccoOrFood" => "1",
	    	"_1applicationType" => "1",
	    	"_1toRegisterPlace" => true,
	    	"_1toRenewLicense" => false,
	    	"_1registerPlace" => "1",
	    	"_1renewLicense" => "1",
    	]);


    	$expected = array_replace($this->defaultExpected(), [
			"business_id" => $business->id,
			"_1registrationNumber" => $registrationNo,
			"_1tobaccoOrFood" => "1",
	    	"_1applicationType" => null,
			"_1toRegisterPlace" => true,
			"_1toRenewLicense" => false,
			"_1registerPlace" => null,
			"_1renewLicense" => null,
			"permit_type" => "Tobacco",
			"register_or_renew" => "-",
    	]);


	    $response = $this->patchJson("/api/applications/{$application->id}", $data);

	    $response->assertJson($expected);

		$this->assertDatabaseHas('applications', [
			'id' => $application->id,
			'business_id' => $business->id,
			'status' => 'draft',
		]);
	    
	    $response->assertStatus(200);
    }

    protected function defaultRequestData()
    {
    	return [
	    	// "_1tobaccoOrFood" => "2",
	    	// "_1applicationType" => "1",
	    	// "_1toRegisterPlace" => true,
	    	// "_1toRenewLicense" => false,
	    	// "_1registerPlace" => "1",
	    	// "_1renewLicense" => "1",
	    	"_1registrationNumber" => "SOMEREGNO1",
	    	"_1wantLicenseIndhivehi" => true,
	    	"_1wantLicenseInenglish" => true,
	    	"_1date" => "fgfdg",
	    	"_2name" => 'Some Name',
	    	"_2idNo" => 'A345357',
	    	"_2address" => 'Soeme e Aadsd',
	    	"_2phone" => '56456456',
	    	"_3name" => 'Namef dgfd',
	    	"_3idNo" => 'A7567456',
	    	"_3address" => 'Ajhdjfh sdfsdfj',
	    	"_3phone" => '968546984',
	    	"_4placeName" => 'Plak csjdf sd',
	    	"_4placeAddress" => 'Jjdsfjk dfds',
	    	"_4road" => "dfjdk fdgjkfd",
	    	"_4blockNumber" => "fdgdf",
	    	"_4numberOfServingAreas" => "fdgdfg",
	    	"_4numberOfChairs" => "fdgfdg",
	    	"_5cat11" => true,
	    	"_5cat12" => false,
	    	"_5cat13" => true,
	    	"_5cat14" => false,
	    	"_5cat15" => true,
	    	"_5cat21" => false,
	    	"_5cat31" => true,
	    	"_5cat32" => false,
	    	"_5cat33" => true,
	    	"_5cat41" => false,
	    	"_5cat42" => true,
	    	"_5cat43" => false,
	    	"_5cat51" => true,
	    	"_5cat61" => false,
	    	"_5cat62" => true,
	    	"_5cat71" => true,
	    	"_5cat81" => false,
	    	"_5cat91" => false,
	    	"_5cat101" => true,
	    	"_5cat101text" => "fdgfdg"
	    ];
    }

    protected function defaultExpected()
    {
    	return [
			// "_1applicationType" => "1",
			"_1date" => "fgfdg",
			"_1registerPlace" => "1",
			"_1registrationNumber" => "SOMEREGNO1",
			// "_1renewLicense" => null,
			// "_1toRegisterPlace" => true,
			// "_1toRenewLicense" => false,
			// "_1tobaccoOrFood" => "2",
			"_1wantLicenseIndhivehi" => true,
			"_1wantLicenseInenglish" => true,
			"_2address" => 'Soeme e Aadsd',
			"_2idNo" => 'A345357',
			"_2name" => 'Some Name',
			"_2phone" => '56456456',
			"_3address" => 'Ajhdjfh sdfsdfj',
			"_3idNo" => 'A7567456',
			"_3name" => 'Namef dgfd',
			"_3phone" => '968546984',
			"_4blockNumber" => "fdgdf",
			"_4numberOfChairs" => "fdgfdg",
			"_4numberOfServingAreas" => "fdgdfg",
			"_4placeAddress" => 'Jjdsfjk dfds',
			"_4placeName" => 'Plak csjdf sd',
			"_4road" => "dfjdk fdgjkfd",
			"_5cat101" => true,
			"_5cat101text" => "fdgfdg",
			"_5cat11" => true,
			"_5cat12" => false,
			"_5cat13" => true,
			"_5cat14" => false,
			"_5cat15" => true,
			"_5cat21" => false,
			"_5cat31" => true,
			"_5cat32" => false,
			"_5cat33" => true,
			"_5cat41" => false,
			"_5cat42" => true,
			"_5cat43" => false,
			"_5cat51" => true,
			"_5cat61" => false,
			"_5cat62" => true,
			"_5cat71" => true,
			"_5cat81" => false,
			"_5cat91" => false,
			// "updated_at" => "2019-02-12 19:15:24",
			// "created_at" => "2019-02-12 19:15:24",
			"id" => 1,
			// "permit_type" => "Food",
			// "register_or_renew" => "New Registration",
		];
    }
}
    