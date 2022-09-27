<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
class UserController extends Controller implements UserInterface
{
    private UserInterface $userRepository;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Foydalanuvchilarni olish
     * @authenticated
     * @queryParam search string
     */
    public function index()
    {
        return $this->userRepository->index();
    }

    /**
     * Foydalanuvchi yaratish
     * @authenticated
     */
    public function store(UserRequest $request)
    {
        return $this->userRepository->store($request);
    }

    /**
     * Tanlangan foydalanuvchini olish
     * @authenticated
     */
    public function show(User $user)
    {
        return $this->userRepository->show($user);
    }

    /**
     * Foydalanuvchi ma'lumotlarini o'zgartirish
     * @bodyParam username string required
     * @bodyParam full_name string required
     */
    public function update(Request $request, User $user)
    {
        return $this->userRepository->update($request, $user);
    }

    /**
     * Foydalanuvchi status ni o'zgartirish
     * @authenticated
     */
    public function changeStatus(User $user)
    {
        return $this->userRepository->changeStatus($user);
    }

    /**
     * Faol bo'lgan foydalanuvchilarni barchasini olish
     * @authenticated
     */
    public function getActiveUsers()
    {
        return $this->userRepository->getActiveUsers();
    }
}
