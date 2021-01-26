<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    /** @var User */
    protected $user;

    /**
     * UserController constructor.
     *
     * @param UserRepository $repository
     * @throws JWTException
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth:api')->except(["allUsers", "oneUser"]);

        try {
            if (!$this->user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'errors' => [
                        'message' => 'That User does not exist'
                    ]
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            throw new JWTException($e->getMessage(), 401);
        }

        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allUsers(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            $this->repository->collectionName => $this->repository->all()
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneUser(User $user): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            $this->repository->collectionName => $this->repository->find($user->getKey())
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        if (Auth::id() !== $user->getKey()) {
            return response()->json([
                "error" => "You are not unauthorized to perform this action."
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->only([
            "name",
            "password",
            "pronouns",
            "relationship_status",
            "profession",
            "province",
            "city",
            "postal_code",
            "year_of_entry",
            "nigerian_identity",
            "gender",
            "topics",
        ]);

        $data["id"] = $user->getKey();

        return response()->json([
            "updated" => $this->repository->update($data)
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        if (Auth::id() !== $user->getKey()) {
            return response()->json([
                "error" => "You are not unauthorized to perform this action."
            ], Response::HTTP_UNAUTHORIZED);
        }

        $this->repository->destroy($user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
