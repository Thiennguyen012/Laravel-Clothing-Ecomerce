<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use App\Repository\Interfaces\IBaseRepository;

abstract class BaseRepository implements IBaseRepository
{

    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function find(array $conditions = [])
    {
        return $this->model->where($conditions)->get();
    }
    public function findOne(array $condition = [])
    {
        $result = $this->model->where($condition)->first();
        return $result;
    }
    public function save(array $data = [])
    {
        $this->model->save($data);
    }
}
