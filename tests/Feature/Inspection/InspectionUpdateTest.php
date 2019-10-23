<?php


namespace Tests\Feature\Inspection;

use App\Inspection;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InspectionUpdateTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function can_update_inspection()
    {
		$this->authenticated();
		$this->hasPermission('inspections.update');

		$inspection = factory(Inspection::class)->create();

		$inspectionAt = Carbon::now()->addDays(20);

		$data = [
			'inspection_at' => $inspectionAt->format('Y-m-d H:i:s'),
			'reason' => 'zz zz z',
			'remarks' => 'too busy',
			'status' => "scheduled",
		];

	    $response = $this->patchJson("/api/inspections/{$inspection->id}", $data);

	    $this->assertDatabaseHas('inspections', [
	    	'id' => $inspection->id,
	    	'inspection_at' => $inspectionAt,
			'reason' => 'zz zz z',
			'remarks' => 'too busy',
			'status' => "scheduled",
	    ]);

	    $response->assertOk();
	}
}