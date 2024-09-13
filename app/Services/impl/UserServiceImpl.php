<?php

namespace App\Services\impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $users = [
        'yuta' => 'yuta32154',
        'atuy' => 'atuy32154',
        'yoet' => 'yoet32154'
    ];
    function login(string $user, string $password): bool
    {
        if(isset($this->users[$user]) && $this->users[$user] === $password){
            return true;
        }

        return false;
    }
}
