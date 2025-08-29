<?php

namespace App\Repository\Interfaces;

interface IBaseRepository
{

    public function find(array $condition = []);
    public function findOne(array $condition = []);
    public function save(array $data = []);
    public function create(array $attributes);
    public function update($id, array $data);
    public function delete($id);
}
