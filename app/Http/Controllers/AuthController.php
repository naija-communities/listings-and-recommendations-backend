<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * AuthController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param StoreRequest $request
     */
    public function register(StoreRequest $request)
    {
        $data = $request->only([
            "name",
            "email",
            "password",
            "pronouns",
            "relationship_status",
            "profession",
            "province",
            "city",
            "postal_code",
            "year_of_entry"
        ]);

        return response()->json([
            'created' => $this->repository->store($data)
        ]);
    }

    public function login()
    {
        dd("loggin in");
    }

    public function logout()
    {
        dd("logging out");
    }
}
