<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupToStudent;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'student_id' => 'required',
            'group_id' => 'required',
        ], [
            'amount.required' => 'To`lov miqdori kiritilmadi',
            'student_id.required' => 'Student tanlanmadi',
            'group_id.required' => 'Guruh tanlanmadi',
        ]);

        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        Payment::create([
            'amount' => $request->amount,
            'student_id' => $request->student_id,
            'group_id' => $request->group_id,
        ]);
        $credit = GroupToStudent::where('student_id', $request->student_id)
            ->where('group_id', $request->group_id)
            ->first()->credit;
        GroupToStudent::where('student_id', $request->student_id)
            ->where('group_id', $request->group_id)
            ->update([
                'credit' => $credit - $request->amount
            ]);
        return response()->json(['message' => 'To\'lov amalga oshirildi'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

// Bu maosh berish jarayoni amalga oshiradi
    public function update(Request $request, $teacher_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'amount' => 'required',
        ],[
            'user_id.required' => 'Pagini yangilab qaytadan urinib ko`ring',
            'amount.required' => 'Pagini yangilab qaytadan urinib ko`ring',
        ]);
        if ($validator->fails())
            return \response()->json(['message' => $validator->getMessageBag()],400);
        DB::beginTransaction();
        try {
            Group::where('teacher_id', $teacher_id)
                ->Join('payments', 'payments.group_id', '=', 'groups.id')
                ->where('payments.status', true)
                ->update([
                    'payments.status' => false
                ]);
            PaymentHistory::create([
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'addBy' => Auth::id()
            ]);
            DB::commit();
            return \response()->json(['message' => 'Maosh berish tasdiqlandi'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return \response()->json(['message' => 'Xatolik yuz berdi'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
