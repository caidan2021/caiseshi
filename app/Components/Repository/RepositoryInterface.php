<?php

namespace App\Components\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RepositoryInterface
{

    /**
     * @return string
     */
    public function targetModel();

    /**
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes);

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes);

    /**
     * @param Model $model
     * @return bool
     */
    public function update($model);

    /**
     * @param $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete($id);

    /**
     * @param int $id
     * @param bool $failOnNotFound
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findById($id, $failOnNotFound = false);

    /**
     * @param array $conditions
     * @param array $options
     * @return Model|null
     */
    public function first(array $conditions = [], array $options = []);

    /**
     * @param array $conditions
     * @param array $options
     * @return Model
     * @throws ModelNotFoundException
     */
    public function firstOrFail(array $conditions = [], array $options = []);

    /**
     * @param array $conditions
     * @param array $options
     * @return Collection
     */
    public function get(array $conditions = [], array $options = []);

    /**
     * @param array $conditions
     * @param array $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $conditions, array $options = []);

    /**
     * @param string $column
     * @param array $conditions
     * @param array $options
     * @return Collection
     */
    public function pluck($column, array $conditions, array $options = []);

    /**
     * @param string $column
     * @param array $conditions
     * @param array $options
     * @return string|null
     */
    public function value($column, array $conditions, array $options = []);

    /**
     * @param array $conditions
     * @return int
     */
    public function count(array $conditions = []);

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []);
}
