<?php


namespace Tests\Feature\Inspection;

use App\Inspection;
use App\NormalCategory;
use App\NormalForm;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class NormalFormsPointTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function can_get_normal_form_points()
    {
		$this->authenticated();
		$this->hasPermission('api.normal-forms.points');
		Artisan::call('db:seed', ['--class' => \NormalPointsTableSeeder::class]);
		$form = factory(NormalForm::class)->create();

	    $response = $this->getJson("/api/normalforms/{$form->id}/points");

	    $response->assertOk();
	}
}