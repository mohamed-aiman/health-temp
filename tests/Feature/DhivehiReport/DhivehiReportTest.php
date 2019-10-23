<?php


namespace Tests\Feature\DhivehiReport;

use App\DhivehiReport;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DhivehiReportTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    
    // /**
    // *@test
    // **/
    // public function can_update_dhivehi_report_good_for_english_report()
    // {
    //     factory(DhivehiReport::class)->create(['id' => 2]);

    //     $response = $this->patchJson('/dhivehi/reports/2', [
    //         'inspection_id' => 1,
    //         'scope' => 'dummy update data',
    //         'critical' => 'dummy update data',
    //         'major' => 'dummy update data',
    //         'minor' => 'dummy update data',
    //         'areas' => 'dummy update data',
    //         'comments' => 'dummy update data',
    //         'verified_by' => 1,
    //         'inspectionMember1Name' => 'dummy update data',
    //         'inspectionMember1Designation' => 'dummy update data',
    //         'inspectionMember1Date' => 'dummy update data',
    //         'inspectionMember2Name' => 'dummy update data',
    //         'inspectionMember2Designation' => 'dummy update data',
    //         'inspectionMember2Date' => 'dummy update data',
    //         'verifiedByName' => 'dummy update data',
    //         'verifiedByDesignation' => 'dummy update data',
    //         'verifiedByDate' => 'dummy update data',
    //     ]);


    //     $response->assertOk();
    //     // dd($response);
    // }

    /**
    *@test
    **/
    public function can_update_dhivehi_report()
    {
        factory(DhivehiReport::class)->create(['id' => 2]);

        $response = $this->patchJson('/dhivehi/reports/2', [
            'inspection_id' => 1,
            'purpose' => 'dummy update data',
            'place_name_address' => 'dummy update data',
            'place_owner_name_address' => 'dummy update data',
            'phone' => 'dummy update data',
            'information_provider' => 'dummy update data',
            'time_of_inspection' => 'dummy update data',
            'number_of_inspections' => 10,
            'critical' => 'dummy update data',
            'major' => 'dummy update data',
            'minor' => 'dummy update data',
            'tobacco' => 'dummi',
            'fine_slip_numbers' => 'dummi',
            'critical_totals' => 'dummy update data',
            'major_totals' => 'dummy update data',
            'minor_totals' => 'dummy update data',
            'tobacco_totals' => 'dummi',
            // 'areas' => 'dummy update data',
            // 'comments' => 'dummy update data',
            // 'verified_by' => 1,
            // 'inspectionMember1Name' => 'dummy update data',
            // 'inspectionMember1Designation' => 'dummy update data',
            // 'inspectionMember1Date' => 'dummy update data',
            // 'inspectionMember2Name' => 'dummy update data',
            // 'inspectionMember2Designation' => 'dummy update data',
            // 'inspectionMember2Date' => 'dummy update data',
            // 'verifiedByName' => 'dummy update data',
            // 'verifiedByDesignation' => 'dummy update data',
            // 'verifiedByDate' => 'dummy update data',
        ]);


        $response->assertOk();
        // dd($response);
    }

    // /**
    // *@test
    // **/
    // public function can_see_dhivehi_report()
    // {
    //     factory(DhivehiReport::class)->create(['id' => 2]);

    //     $response = $this->get('api/dhivehi/reports/2');

    //     $response->assertOk();

    //     dd($response);
    // } 
}
