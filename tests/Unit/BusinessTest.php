<?php

namespace Tests\Unit;

use App\Business;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BusinessTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    /**
     * @return void
     * @test
     */
    public function business_show()
    {
    	factory(Business::class)->create(['id' => 10]);
    	$response = $this->get('/businesses/10');
    	// dd($response);
    	$response->assertOk();

    }
}
