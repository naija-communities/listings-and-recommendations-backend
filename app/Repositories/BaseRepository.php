<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    public $collectionName;

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all()
    {
        return $this->model::all();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($data): bool
    {
        return DB::table($this->table)->where("id", "=", $data["id"])->update($data);
    }

    /**
     * @param Model $model
     * @return int
     */
    public function destroy(Model $model): int
    {
        return $this->model->destroy($this->find($model->getKey())->getKey());
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
