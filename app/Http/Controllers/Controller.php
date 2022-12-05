<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(public User $user)
    {
    }

    protected function authCan($ruleKey)
    {
        return User::join('user_has_rules as ur', 'ur.user_id', '=', 'users.id')
            ->join('rules as r', 'r.id', '=', 'ur.rule_id')
            ->where('users.id', auth()->id())
            ->where('r.key', $ruleKey)
            ->count();
    }

    protected function forbidden()
    {
        return response()->json([
            'message' => ['forbidden' => ['Amalyotga ruxsat berilmagan']]
        ], 403);
    }
}
