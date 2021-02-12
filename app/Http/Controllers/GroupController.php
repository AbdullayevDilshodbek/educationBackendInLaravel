<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupToStudent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return GroupResource::collection(Group::orderByDesc('id')
            ->where('subject_id',$request->subject_id > 0 ? '=' : '>',$request->subject_id ? $request->subject_id : 0)
            ->Join('teachers','teachers.id','=','groups.teacher_id')
            ->Join('subjects','subjects.id','=','teachers.subject_id')
            ->select(['groups.*'])
            ->paginate(6));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $group_name = $request->group_name;
        $validator = Validator::make($request->all(), [
            'group_name' => 'required',
            'teacher_id' => ['required', Rule::unique('groups')->where(function ($query) use ($teacher_id, $group_name) {
                return $query->where('teacher_id', $teacher_id)->where('group_name', $group_name);
            })],
            'payment' => 'required|numeric',
            'teacher_part' => 'required',
        ], [
            'group_name.required' => 'Guruh nomi kiritilmadi',
            'teacher_id.required' => 'O`qituvchi tanlanmadi',
            'teacher_id.unique' => 'O`qituvchi allaqaachon bu nomdagi guruh mavjud',
            'payment.required' => 'Oylik to`lov miqdori kiritilmadi',
            'teacher_part.required' => 'O`qituvchining ulishi kiritilmadi'
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        Group::create([
            'group_name' => $request->group_name,
            'teacher_id' => $request->teacher_id,
            'payment' => $request->payment,
            'teacher_part' => $request->teacher_part / 100.0,
        ]);
        return response()->json(['message' => 'Guruh yaratildi'], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return GroupResource
     */
    public function show($id)
    {
        return new GroupResource(Group::find($id));
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
        $group_name = $request->group_name;
        $teacher_id = $request->teacher_id;
        $validator = Validator::make($request->all(), [
            'group_name' => 'required',
            'teacher_id' => ['required', Rule::unique('groups')->where(function ($query) use ($id, $group_name, $teacher_id) {
                return $query->where('group_name', '=', $group_name)->where('teacher_id', '=',$teacher_id)->where('id','!=',$id);
            })],
            'payment' => 'required',
            'teacher_part' => 'required',
        ], [
            'group_name.required' => 'Guruh nomi kiritilmadi',
            'teacher_id.required' => 'O`qituvchi tanlanmadi',
            'teacher_id.unique' => 'O`qituvchi allaqaachon bu nomdagi guruh mavjud',
            'payment.required' => 'Oylik to`lov miqdori kiritilmadi',
            'teacher_part.required' => 'O`qituvchining ulishi kiritilmadi'
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        Group::find($id)->update([
            'group_name' => $request->group_name,
            'teacher_id' => $request->teacher_id,
            'payment' => $request->payment,
            'teacher_part' => $request->teacher_part/100.0,
        ]);
        return response()->json(['message' => 'Guruh ma`lumotlari yangilandi'], 200);
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

    public function changeStatus($group_id)
    {
        $group = Group::find($group_id);
        $message = $group->status ? 'Guruh nofaollashtirildi' : 'Guruh faollashtirildi';
        $group->update([
            'status' => !$group->status
        ]);
        return \response()->json(['message' => $message], 200);
    }

    public function getGroupsOfTeacher($group_id){
        $teacher_id = Group::find($group_id)->teacher_id;
        return Group::where('teacher_id',$teacher_id)
            ->orderByDesc('id')
            ->get(['id','group_name']);
    }

    public function getGroupsOfStudent($student_id){
        $groups_id = GroupToStudent::where('student_id',$student_id)->pluck('group_id');
        return Group::whereIn('id',$groups_id)
            ->orderByDesc('id')
            ->get(['id','group_name']);
    }
}
