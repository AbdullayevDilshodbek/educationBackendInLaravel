<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Subject::orderByDesc('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'subject_name' => 'required|unique:subjects'
        ],[
            'subject_name.unique' => 'Bu fan allaqachon mavjud',
            'subject_name.required' => 'Fan nomi kiritilmadi'
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()],400);
        Subject::create([
            'subject_name' => $request->subject_name
        ]);
        return response()->json(['message' => 'Fan yaratildi'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $subject_name = $request->subject_name;
        $validator = Validator::make($request->all(),[
            'subject_name' => ['required',Rule::unique('subjects')->where(function ($query) use ($subject_name,$id){
                return $query->where('subject_name','=',$subject_name)->where('id','!=',$id);
            })]
        ],[
            'subject_name.unique' => 'Bu fan allaqachon mavjud',
            'subject_name.required' => 'Fan nomi kiritilmadi'
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()],400);
        Subject::find($id)->update([
            'subject_name' => $request->subject_name
        ]);
        return response()->json(['message' => 'Fan nomi yangilandi'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus($subject_id)
    {
        $subject = Subject::find($subject_id);
        $message = $subject->status ? 'Fan nofaollashtirildi' : 'Fan faollashtirildi';
        $subject->update([
            'status' => !$subject->status
        ]);
        return \response()->json(['message' => $message],200);
    }
}
