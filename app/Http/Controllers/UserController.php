<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::orderByDesc('id')
//            ->where('id',$request->user_id ? '=' : '>',$request->user_id ? $request->user_id : 0)
            ->paginate(10));
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
            'username' => 'required',
            'full_name' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username kiritilmadi',
            'full_name.required' => 'Full name kiritilmadi',
            'password.required' => 'password kiritilmadi',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => bcrypt($request->password),
        ]);
        return response()->json(['message' => 'Foydalanuvchi yaratildi'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function show($id)
    {
        return collect(User::find($id))->except('password','created_at','updated_at');
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
        $username = $request->username;
        $password = bcrypt($request->password);
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'full_name' => 'required',
            'password' => $request->password ? ['required', Rule::unique('users')->where(function ($query) use ($username,$password){
                return $query->where('username',$username)->where('password',$password);
            })] : ''
        ], [
            'username.required' => 'Username kiritilmadi',
            'full_name.required' => 'Full name kiritilmadi',
            'password.required' => 'password kiritilmadi',
            'password.unique' => 'Belgilardan foydalaning',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        $user = User::find($id);
        $request->password ? $user->update([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => bcrypt($request->password),
        ]) : $user->update([
            'username' => $request->username,
            'full_name' => $request->full_name,
        ]);
        return response()->json(['message' => 'Foydalanuvchi ma\'limotlari yangilandi'], 200);
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

    public function changeStatus($user_id)
    {
        $user = User::find($user_id);
        $user->update([
            'status' => !$user->status
        ]);
        $message = $user->status ? 'Foydalanuvchi faollashtirildi' : 'Foydalanuvchi nofaollashtirildi';
        return response()->json(['message' => $message], 200);
    }
}
