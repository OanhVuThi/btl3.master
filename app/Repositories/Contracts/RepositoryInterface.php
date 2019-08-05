<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function getAll();

    public function get($key, $value);

    public function find($id);

    public function create(array $attribute);

    public function update($id, array $attribute);

    public function delete($id);
}
