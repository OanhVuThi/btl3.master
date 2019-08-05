<?php
namespace App\Repositories;

use App\Repositories\Contracts\EloquentRepository;


class UserRepository extends EloquentRepository
{
    public function getModel()
    {
        return \App\User::class;
    }
}
