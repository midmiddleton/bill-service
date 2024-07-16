<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bill;
use App\Http\Controllers\BillController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SetStageOnAllBillsTest extends TestCase
{
    use RefreshDatabase;

    public function testSetStageOnAllBillThroughController()
    {
        $billsWithNoStage = Bill::factory()->count(5)->create();

        foreach ($billsWithNoStage as $bill){
            $bill->bill_stage_id = 100;
            $bill->save();
        }

        Bill::factory()->count(5)->create();

        $response = with(
            new BillController(),
            function ($billController) {
                return $billController->setStageOnAllBills(new Request());
            }
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals(5, $response->getData()->bills_fixed);
        $this->assertEquals('Set stage on 5 bills', $response->getData()->message);
    }

    public function testSetStageOnAllBillThroughEndpoint()
    {
        $billsWithNoStage = Bill::factory()->count(5)->create();

        foreach ($billsWithNoStage as $bill){
            $bill->bill_stage_id = 100;
            $bill->save();
        }

        Bill::factory()->count(5)->create();

        $response = $this->put('/api/bills/set-stages');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals(5, $response->getData()->bills_fixed);
        $this->assertEquals('Set stage on 5 bills', $response->getData()->message);
    }

    public function testSetStageOnAllBillThroughControllerWithDefaultStageSet()
    {
        $billsWithNoStage = Bill::factory()->count(5)->create();

        foreach ($billsWithNoStage as $bill){
            $bill->bill_stage_id = 100;
            $bill->save();
        }

        Bill::factory()->count(5)->create();

        $response = with(
            new BillController(),
            function ($billController) {
                return $billController->setStageOnAllBills(new Request(['stage' => 42]));
            }
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals(5, $response->getData()->bills_fixed);
        $this->assertEquals('Set stage on 5 bills', $response->getData()->message);
        $numberOfBillsAtStage42 = (Bill::all())->where('bill_stage_id', 42)->count();
        $this->assertEquals(5, $numberOfBillsAtStage42);
    }

    public function testSetStageOnAllBillThroughEndpointWithDefaultStageSet()
    {
        $billsWithNoStage = Bill::factory()->count(5)->create();

        foreach ($billsWithNoStage as $bill){
            $bill->bill_stage_id = 100;
            $bill->save();
        }

        Bill::factory()->count(5)->create();

        $response = $this->put('/api/bills/set-stages', ['stage' => 42]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals(5, $response->getData()->bills_fixed);
        $this->assertEquals('Set stage on 5 bills', $response->getData()->message);
        $numberOfBillsAtStage42 = (Bill::all())->where('bill_stage_id', 42)->count();
        $this->assertEquals(5, $numberOfBillsAtStage42);
    }
}