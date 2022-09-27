<?php

namespace App\Repositories\User;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface
{
    public function index();
    public function store(UserRequest $request);
    public function show(User $user);
    public function update(Request $request, User $user);
    public function changeStatus(User $user);
    public function getActiveUsers();
}
