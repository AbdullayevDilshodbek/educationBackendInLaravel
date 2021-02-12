<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TeacherResource::collection(Teacher::orderByDesc('id')
            ->paginate(env('PG')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $subject_id = $request->subject_id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'subject_id' => ['required',Rule::unique('teachers')->where(function ($query) use ($user_id,$subject_id){
                return $query->where('user_id',$user_id)->where('subject_id',$subject_id);
            })]
        ], [
            'user_id.required' => 'O\'qituvchi tanlanmadi',
            'subject_id.required' => 'Fan tanlanmadi',
            'subject_id.unique' => 'Bu o`qituvchi allaqachon qayd etilgan',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        Teacher::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
        ]);
        return response()->json(['message' => 'Muvaffaqiyatli yaratildi'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TeacherResource
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
        $user_id = $request->user_id;
        $subject_id = $request->subject_id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'subject_id' => ['required',Rule::unique('teachers')->where(function ($query) use ($user_id,$subject_id){
                return $query->where('user_id',$user_id)->where('subject_id',$subject_id);
            })]
        ], [
            'user_id.required' => 'O\'qituvchi tanlanmadi',
            'subject_id.required' => 'Fan tanlanmadi',
            'subject_id.unique' => 'Bu o`qituvchi allaqachon qayd etilgan',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        Teacher::find($id)->update([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
        ]);
        return response()->json(['message' => 'Muvaffaqiyatli yangilandi'], 201);
    }

    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        if (is_null($teacher)) {
            return response()->json(['message' => 'O\'qituvchi topilmadi'], 400);
        }
        $teacher->delete();
        return response()->json(['message' => 'O\'qituvchi muvaffaqiyatli o\'chirildi'], 204);
    }
    public function getTeachersOfSubject(Request $request)
    {
        return TeacherResource::collection(Teacher::orderByDesc('id')
        ->where('subject_id',$request->subject_id ? '=' : '>',$request->subject_id ? $request->subject_id : 0)
            ->get());
    }
}
