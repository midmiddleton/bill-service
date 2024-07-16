<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;
use Tests\TestCase;
use App\Http\Controllers\BillController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddBillTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testABillIsAddedThroughController(): void
    {
        //set up
        $request = new Request($this->createBillData());

        //execute
        $response = with (
            new BillController(),
                function ($billController) use ($request) {
                    return $billController->store($request);
                }
            );

        //assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertDatabaseCount('bills', 1);
        $this->assertDatabaseHas('bills', $this->createBillData());

    }

    public function testABillIsAddedThroughEndpoint(): void
    {
        //execute
        $response = $this->post('/api/bills', $this->createBillData());

        //assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertDatabaseCount('bills', 1);
        $this->assertDatabaseHas('bills', $this->createBillData());
    }

    // I hadnt noticed a factory existed when I did this. I would have used it if I had seen it.
    private function createBillData(): array
    {
        return [
            'bill_reference' => 'Electricity',
            'bill_date' => Carbon::now()->toDateTimeString(),
            'submitted_at' => Carbon::now()->toDateTimeString(),
            'approved_at' => Carbon::now()->toDateTimeString(),
            'on_hold_at' => Carbon::now()->toDateTimeString(),
            'bill_stage_id' => 7,
        ];
    }
}

// Create an endpoint that receives a JSON payload to add a new bill to the database
