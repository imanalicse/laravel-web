<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserTrait {

    public function getAuthUser(): array
    {
        $user = [];
        $auth_user = Auth::user();
        if (!empty($auth_user)) {
            $user = $auth_user->toArray();
        }
        return $user;
    }

    public function getAuthId(): int|string|null
    {
        return Auth::id();
    }
}
