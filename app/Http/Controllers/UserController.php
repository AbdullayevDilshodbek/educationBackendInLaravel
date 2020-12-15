<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'full_name' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username kiritilmadi',
            'full_name.required' => 'Full name kiritilmadi',
            'password.required' => 'password kiritilmadi',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()],400);
        User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => bcrypt($request->password),
        ]);
        return response()->json(['message' => 'Foydalanuvchi yaratildi'],201);
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

    public function test(Request $request){

    }
}
