<?php

namespace App\Repositories;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function __construct(private User $user, private Auth $auth, private Hash $hash)
    {
    }

    public function index()
    {
        $search = request('search', '');
        $authUser = $this->auth::user();
        $users = $this->user::with(['position.organization'])
            ->whereHas(
                'position.organization',
                fn ($q) => $q->where('organization_id', $authUser->position->organization->id)
            )
            ->where('full_name', 'ilike', "%$search%")
            ->orderByDesc('id')
            ->paginate(2);
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $this->user::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'picture_name' => null,
            'position_id' => $request->position_id
        ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')], 200);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'position_id' => $request->position['id']
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

    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = $this->user::where('username', $request->get('username'))->first();
        if (!$user)
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
        if (!$this->hash::check($request->get('password'), $user->password))
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

        $token = $user->createToken(env('APP_NAME'))->accessToken;
        return ['token' => $token];
    }

    public function authUser()
    {
        return $this->auth::user();
    }
}
