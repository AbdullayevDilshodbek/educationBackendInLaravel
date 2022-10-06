<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRepository implements UserInterface
{
    public function __construct(private User $user, private Auth $auth)
    {
    }

    public function index()
    {
        $search = request('search', '');
        $authUser = $this->auth::user();
        $users = $this->user::with(['position.organization'])
            ->whereHas(
                'position.organization',
                fn ($q) => $q->where('organization_id', $authUser->organization_id)
            )
            ->where('full_name', 'like', "%$search%")
            ->orderByDesc('id')
            ->paginate(env('PG'));
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $this->user::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'position_id' => $request->position_id
        ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')], 200);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', Rule::unique('users')->where(
                function ($q) use ($user) {
                    $q->where('username', $user->username)
                        ->where('id', '!=', $user->id);
                }
            )],
            'full_name' => 'required',
            'position_id' => 'required'
        ], [
            'username.required' => 'Login kiritilmadi',
            'username.unique' => 'Login qiyinroq bo\'lishi lozim',
            'full_name.required' => 'Foydalanuvchi F.I.O si kiritilmadi',
            'position_id.required' => 'Lavozim tanlanmadi'
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        $user->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $request->password,
            'position_id' => $request->position_id
        ]);
        return response()->json(['message' => env("MESSAGE_SUCCESS")], 200);
    }

    public function changeActive(User $user)
    {
        $user->update([
            'active' => !$user->active
        ]);
        return response()->json(['message' => env("MESSAGE_SUCCESS")], 200);
    }
}
