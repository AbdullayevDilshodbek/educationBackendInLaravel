<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupToStudentResource;
use App\Models\Group;
use App\Models\GroupToStudent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GroupToStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return GroupToStudentResource::collection(GroupToStudent::orderByDesc('id')
            ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $student_id = $request->student_id;
        $group_id = $request->group_id;
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'group_id' => ['required', Rule::unique('group_to_students')->where(function ($query) use ($student_id, $group_id) {
                return $query->where('student_id', $student_id)->where('group_id', $group_id);
            })],
            'discount' => 'required',
            'pay_part' => 'required',
        ], [
            'student_id.required' => 'Student tanlanmadi',
            'group_id.required' => 'Gurux tanlanmadi',
            'group_id.unique' => 'Bu guruhda allaqachon bu student mavjud',
            'discount.required' => 'Chegirma kiritilmagan',
            'pay_part.required' => 'Shu oy uchun to`lov miqdori kiritilmagan',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        GroupToStudent::create([
            'student_id' => $request->student_id['id'],
            'group_id' => $request->group_id,
            'discount' => $request->discount,
            'credit' => ((100 - $request->discount) / 100) * Group::find($request->group_id)->payment * $request->pay_part / 100,
        ]);
        return response()->json(['message' => 'Student guruhga qo`shildi'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $student_id = $request->student_id;
        $group_id = $request->group_id;
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'group_id' => ['required', Rule::unique('group_to_students')->where(function ($query) use ($student_id, $group_id) {
                return $query->where('student_id', $student_id)->where('group_id', $group_id);
            })],
            'discount' => 'required',
        ], [
            'student_id.required' => 'Student tanlanmadi',
            'group_id.required' => 'Gurux tanlanmadi',
            'group_id.unique' => 'Bu guruhda allaqachon bu student mavjud',
            'discount.required' => 'Chegirma kiritilmagan',
        ]);
        // tayyorlanyapti
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        $lenght_the_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime('-1 month')), date("Y"));
        $the_day = date("d");
        $group_to_student = GroupToStudent::find($id);
        $old_group = Group::find($group_to_student->group_id);
        if ($group_to_student->change_group_date == null
            || date_format(strtotime($group_to_student->change_group_date ? $group_to_student->change_group_date : date("Y-m")), 'Y-m') != date("Y-m")
            || $group_to_student->credit >= $old_group->payment - $old_group->payment*3/100){
            GroupToStudent::find($id)->update([
//                'student_id' => $request->student_id,
//                'group_id' => $request->group_id,
//                'discount' => $request->discount,
                'credit' => $group_to_student->credit
                    - ((100 - $group_to_student->discount) / 100) * $old_group->payment
                    + ($old_group->payment * $the_day / $lenght_the_month)
                    + ((1 - $the_day / $lenght_the_month) * Group::find($group_id)->payment) * (1.00 - $request->discount/100.00),
            'change_group_date' => date('Y-m-d')
            ]);
        return response()->json(['message' => 'Yangilanish amalga oshirildi'], 200);
        } else{
            return \response()->json(['message' =>['forbidden' => ['Amalyotni bu oy bajarishning imkoni yo`q']]],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    public function getStudentsOfGroup($group_id)
    {
        return GroupToStudentResource::collection(GroupToStudent::where('status', true)
            ->where('group_id', $group_id)
            ->orderByDesc('id')
            ->paginate(8));
    }
}
