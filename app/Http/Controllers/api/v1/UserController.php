<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller implements UserInterface
{
    public function __construct(private UserInterface $userRepository)
    {
    }
    /**
     * Foydalanuvchilarni paginatsiya bilan olish
     * @authenticated
     * @queryParam search string
     */
    public function index()
    {
        return $this->userRepository->index();
    }

    /**
     * Yangi foydalanuvchi qo'shish
     * @authenticated
     */
    public function store(UserRequest $request)
    {
        return $this->userRepository->store($request);
    }

    /**
     * Foydalanuvchi ma'lumotlarini yangilash
     * @authenticated
     * @bodyParam username string required Login
     * @bodyParam full_name string required F.I.O
     * @bodyParam password string Parol
     * @bodyParam position_id integer required Lavozim id
     */
    public function update(Request $request, User $user)
    {
        return $this->userRepository->update($request, $user);
    }

    /**
     * Foydalanuvchini faol yoki nofaol qilish
     * @authenticated
     * @param  int  $id
     */
    public function changeActive(User $user)
    {
        return $this->userRepository->changeActive($user);
    }
}
