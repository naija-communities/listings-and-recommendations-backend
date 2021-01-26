<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Creates a new user record
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreRequest $request): \Illuminate\Http\JsonResponse
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
            "year_of_entry",
            "topics"
        ]);

        return response()->json([
            'created' => $this->repository->store($data)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only(["email", "password"]);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid email or password'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], Response::HTTP_OK);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], Response::HTTP_OK);
    }
}
