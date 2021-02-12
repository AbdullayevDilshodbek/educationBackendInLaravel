<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return StudentResource::collection(Student::orderByDesc('id')->get());
//        return Student::paginate(env('PG'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $middle_name = $request->middle_name;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => ['required', Rule::unique('students')->where(function ($query)
            use ($first_name, $last_name, $middle_name) {
                return $query->where('first_name', $first_name)->where('last_name', $last_name)->where('middle_name', $middle_name);
            })],
            'phone' => 'required',
        ], [
            'first_name.required' => 'Ism kiritilmadi',
            'last_name.required' => 'Familya kiritilmadi',
            'middle_name.required' => 'Sharf kiritilmadi',
            'middle_name.unique' => 'Bu student mavjud',
            'phone.required' => 'Telefon raqam kiritilmadi',
        ]);
        if ($validator->fails())
            return \response()->json(['message' => $validator->getMessageBag()], 400);
        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'phone' => $request->phone
        ]);
        return \response()->json(['message' => 'Student yaratildi'], 201);
    }


    public function show($id)
    {
        return StudentResource::collection(Student::where('id', $id)->get());
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
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $middle_name = $request->middle_name;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => ['required', Rule::unique('students')->where(function ($query)
            use ($id, $first_name, $last_name, $middle_name) {
                return $query->where('id', '!=', $id)->where('first_name', $first_name)->where('last_name', $last_name)->where('middle_name', $middle_name);
            })],
            'phone' => 'required',
        ], [
            'first_name.required' => 'first_name kiritilmadi',
            'last_name.required' => 'last_name kiritilmadi',
            'middle_name.required' => 'middle_name kiritilmadi',
            'middle_name.unique' => 'Bu student mavjud',
            'phone.required' => 'phone kiritilmadi',
        ]);
        if ($validator->fails())
            return \response()->json(['message' => $validator->getMessageBag()], 400);
        Student::find($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'phone' => $request->phone
        ]);
        return response()->json(['message' => 'Student ma`lumotlari yangilandi'], 200);
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

    public function changeStatus($student_id)
    {
        $student = Student::find($student_id);
        $message = $student->status ? 'Student nofaollashtirildi' : 'Student faollashtirildi';
        $student->update([
            'status' => !$student->status
        ]);
        return \response()->json(['message' => $message], 200);
    }

    public function getActiveStudents(Request $request)
    {
        $text = $request->text;
        if (!$request->student_id)
            return StudentResource::collection(Student::orderByDesc('id')
                ->where(function ($query) use ($text) {
                    $query->orWhere('first_name', 'like', '%' . $text . '%')
                        ->orWhere('last_name', 'like', '%' . $text . '%')
                        ->orWhere('middle_name', 'like', '%' . $text . '%');
                })
                ->where('status', true)
                ->orderByDesc('id')
                ->get());
        return new StudentResource(Student::find($request->student_id));
    }
}
