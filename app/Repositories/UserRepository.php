<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Hashing\BcryptHasher;

class UserRepository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * @param $data
     * @return bool
     */
    public function store($data)
    {
        if ($data["password"]) {
            $data["password"] = (new BcryptHasher)->make($data['password']);
        }

        return $this->model->create($data);
    }
}
