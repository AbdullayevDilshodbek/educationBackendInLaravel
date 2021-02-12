<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentHistoryResource;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPaymentHistoryOfTeacher(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $user_id = $request->user_id;
        if (!$start_date || !$end_date)
            return PaymentHistoryResource::collection(PaymentHistory::where('user_id', $user_id)
                ->orderByDesc('id')
                ->paginate(env('PG')));
        return PaymentHistoryResource::collection(PaymentHistory::where('user_id', $user_id)
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->orderByDesc('id')
            ->paginate(env('PG')));
    }

//    umumiy oylik lar xisobotini olish uchun davom etirrish kerak yakunlagan
    public function getPaymentHistory(Request $request)
    {
        $start_date = $request->start_date ? $request->start_date : date('Y-m') . "-01";
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');
        PaymentHistoryResource::collection(PaymentHistory::orderByDesc('id')
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->paginate(env('PG')));
    }
}
