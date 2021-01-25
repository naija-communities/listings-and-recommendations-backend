<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Hashing\BcryptHasher;

class UserRepository
{
    protected $topics = [
        "food and drink",
        "sports",
        "technology",
        "mens fashion",
        "womens fashion",
        "lifestyle",
        "family",
        "antenatal care",
        "pregnancy",
        "children",
        "business",
        "finance",
        "investment",
        "tax",
        "account",
        "real estate",
        "apartment rental",
        "groceries",
        "pharmaceuticals",
        "diy crafts",
        "events",
        "car rental",
        "rental",
        "car deals",
        "driving",
        "leisure",
        "shopping",
        "self care",
        "books",
        "weddings",
        "photography",
        "family health",
        "music"
    ];

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

        if ($data["topics"]) {
            $decoded = json_decode($data["topics"], true);
            $toEncode = array_filter($decoded, function ($t) {
                return in_array($t, $this->topics);
            });
        }

        $data["topics"] = json_encode($toEncode);

        return $this->model->create($data);
    }
}
