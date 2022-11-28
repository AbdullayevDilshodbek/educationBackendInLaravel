<?php

namespace App\Interfaces;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

interface UserInterface
{
    public function index();
    public function store(UserRequest $request);
    public function update(UserUpdateRequest $request, User $user);
    public function changeActive(User $user);
    public function login(LoginRequest $request);
    public function authUser();
}
