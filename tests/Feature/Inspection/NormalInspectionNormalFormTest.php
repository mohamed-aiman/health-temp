<?php


namespace Tests\Feature\Inspection;

use App\Inspection;
use App\NormalForm;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class NormalInspectionNormalFormTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function can_start_filling_inspection_form()
    {
		$this->authenticated();
		$this->hasPermission('api.normal-inspections.normalforms.show');
		$inspection = factory(Inspection::class)->create(['normal_form_id' => null]);

	    $response = $this->getJson("/api/normalinspections/{$inspection->id}/normalforms");

	    $this->assertNotNull($inspection->fresh()->normal_form_id);
	    $response->assertOk();
	}

	/**
     * @test
     */
    public function can_start_filling_inspection_form_with_points_loaded()
    {
		$this->authenticated();
		$this->hasPermission('api.normal-inspections.normalforms.show');
		Artisan::call('db:seed', ['--class' => \NormalPointsTableSeeder::class]);
		$inspection = factory(Inspection::class)->create(['normal_form_id' => null]);
	    $response = $this->getJson("/api/normalinspections/{$inspection->id}/normalforms");
	    $form = NormalForm::find($response->json()['id']);
		$this->hasPermission('api.normal-forms.points');
		
	    $response = $this->getJson("/api/normalforms/{$form->id}/points");
	    $formAttacedCategoriesWithPoints = $response->json(); 

	    $this->assertEquals(count($formAttacedCategoriesWithPoints), 14);
	    $response->assertOk();
	}
}