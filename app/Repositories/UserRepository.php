<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Hashing\BcryptHasher;

class UserRepository extends BaseRepository
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
        $this->table = "users";
        $this->collectionName = "users";
    }

    /**
     * @param $data
     * @return Model
     */
    public function store($data): Model
    {
        return $this->save($this->prepare($data));
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($data): bool
    {
        return parent::update($this->prepare($data));
    }

    /**
     * @param $data
     * @return array
     */
    protected function prepare($data): array
    {
        $toEncode = [];

        if ($data["password"]) {
            $data["password"] = (new BcryptHasher)->make($data['password']);
        }

        if (isset($data["topics"])) {
            $decoded = json_decode($data["topics"], true);
            $toEncode = array_filter($decoded, function ($t) {
                return in_array($t, $this->topics);
            });
        }

        if (!empty($toEncode)) {
            $data["topics"] = json_encode($toEncode);
        }

        return $data;
    }
}
