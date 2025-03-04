<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Inertia\Inertia;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BillController extends Controller
{

    public function index()
    {
        $bills = Bill::with('users')->get();
        
        $totalSubmitted = $bills->count();
        $totalApproved = $bills->where('bill_stage_id', '=' , 3)->count();
        $totalOnHold = $bills->where('bill_stage_id', '=', 5)->count();
        $users = User::with('bills')->get();

        return Inertia::render('bills', [
            'bills' => $bills,
            'totals' => [
                'submitted' => $totalSubmitted,
                'approved' => $totalApproved,
                'on_hold' => $totalOnHold,
            ],
            'users'=> $users
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $bill = Bill::create($request->all());

        return response()->json($bill, 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * 
     * Because the database does not allow for nullable values in the bill_stage_id column I decided to 
     * check instead for if the billstage id is not an existing bill stage.
     * We can set the stage with a requested stage id or default it to 1
     */
    public function setStageOnAllBills(Request $request): JsonResponse
    {
        $bills = Bill::all();

        $numberOfBillsFixed = 0;
        foreach ($bills as $bill) {
            if (in_array($bill->bill_stage_id, BillStage::getExistingIds())) {
                if ($request->has('stage')) {
                    $bill->setDefaultStage($request->stage);
                } else {
                    $bill->setDefaultStage();
                }
                $numberOfBillsFixed++;
            }
        }

        $response = [
            'message' => 'Set stage on '.$numberOfBillsFixed .' bills',
            'bills_fixed' => $numberOfBillsFixed,
        ];
        return response()->json($response, 200);
    }
}