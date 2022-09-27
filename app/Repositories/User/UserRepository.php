<?php

namespace App\Repositories\User;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserInterface
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index()
    {
        $search = request('search', '');
        $userId = request('user_id', 0);
        return UserResource::collection($this->user::where(function ($query) use ($search) {
            $query->where('full_name', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%")
                ->orWhere('id', 'like', "%$search%");
        })
            ->where('id', $userId ? '=' : '>', $userId ?? 0)
            ->orderByDesc('id')
            ->paginate(env('PG')));
    }

    public function store(UserRequest $request)
    {
        $this->user::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => bcrypt($request->password),
        ]);
        return response()->json(['message' => 'Foydalanuvchi yaratildi'], 201);
    }

    public function show(User $user)
    {
        return collect($user)->except('password');
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'full_name' => 'required'
        ], [
            'username.required' => 'Username kiritilmadi',
            'full_name.required' => 'Full name kiritilmadi',
        ]);
        if ($validator->fails())
            return response()->json(['message' => $validator->getMessageBag()], 400);
        $user->update([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);
        return response()->json(['message' => 'Foydalanuvchi ma\'limotlari yangilandi'], 200);
    }

    public function changeStatus(User $user)
    {
        $user->update([
            'status' => !$user->status
        ]);
        $message = $user->status ? 'Foydalanuvchi faollashtirildi' : 'Foydalanuvchi nofaollashtirildi';
        return response()->json(['message' => $message], 200);
    }

    public function getActiveUsers()
    {
        return $this->user::where('status', true)->get();
    }
}
