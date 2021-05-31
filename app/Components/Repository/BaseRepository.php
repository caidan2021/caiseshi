<?php

namespace App\Components\Repository;

use App\Components\Model\BaseModel;
use App\Components\Transformer\ModelFractal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var int
     */
    protected static $perPage = 10;

    /**
     * @var ModelFractal|null
     */
    protected $transformer;

    /**
     * 是否要transform
     * @var bool
     */
    protected $transformable = false;

    public function __construct()
    {
        $this->transformable && $this->transformer = app(ModelFractal::class);
    }

    /**
     * @return int
     */
    public static function getPerPage()
    {
        return self::$perPage;
    }

    /**
     * @param int $perPage
     */
    public static function setPerPage($perPage)
    {
        self::$perPage = $perPage;
    }

    /**
     * 对应的模型类，默认与仓库名字相同，可以在仓库内覆盖
     * @return mixed
     */
    public function targetModel()
    {
        return str_replace(['Repository', 'Repos'], ['', 'Models'], static::class);
    }

    /**
     * @return BaseModel
     */
    public function model()
    {
        return app()->make($this->targetModel());
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes)
    {
        return $this->model()->fill($attributes);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes)
    {
        $model = $this->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function update($model)
    {
        return $model->update();
    }

    /**
     * @param $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete($id)
    {
        $model = $this->findById($id, true);

        return $model->delete();
    }

    /**
     * @param int $id
     * @param bool $failOnNotFound
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findById($id, $failOnNotFound = false)
    {
        $method = $failOnNotFound ? 'findOrFail' : 'find';

        return $this->parserResult($this->model()->{$method}($id));
    }

    /**
     * @param $idArr
     * @return \Illuminate\Support\Collection
     */
    public function findMany($idArr)
    {
        return $this->model()->whereIn("id", $idArr)->get();
    }

    /**
     * @param array $conditions
     * @param array $options
     * @return Model|null
     */
    public function first(array $conditions = [], array $options = [])
    {
        return $this->firstWith($conditions, $options);
    }
    
    /**
     * @param $id
     *
     * @return Model|null
     */
    public function firstById($id)
    {
        return $this->first([['id', $id]]);
    }
    

    /**
     * @param array $conditions
     * @param array $options
     * @return Model
     * @throws ModelNotFoundException
     */
    public function firstOrFail(array $conditions = [], array $options = [])
    {
        return $this->firstWith($conditions, $options, true);
    }

    /**
     * @param array $conditions
     * @param array $options
     * @return Collection|\Illuminate\Support\Collection|static[]
     */
    public function get(array $conditions = [], array $options = [])
    {
        return $this->parserResult($this->newQueryWithOptions($options)->where($conditions)->get());
    }

    /**
     * @param array $conditions
     * @param array $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $conditions = [], array $options = [])
    {
        return $this->newQueryWithOptions($options)->where($conditions)->paginate(self::$perPage);
    }

    /**
     * @param string $column
     * @param array $conditions
     * @param array $options
     * @return Collection|mixed
     */
    public function pluck($column, array $conditions, array $options = [])
    {
        return $this->newQueryWithOptions($options)->where($conditions)->pluck($column);
    }

    /**
     * @param string $column
     * @param array $conditions
     * @param array $options
     * @return string|null
     */
    public function value($column, array $conditions, array $options = [])
    {
        return $this->newQueryWithOptions($options)->where($conditions)->value($column);
    }

    /**
     * @param array $conditions
     * @return int
     */
    public function count(array $conditions = [])
    {
        return $this->newQueryWithOptions()->where($conditions)->count();
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = [])
    {
        return $this->newQueryWithOptions()->where($conditions)->exists();
    }

    /**
     * @param array $conditions
     * @param array $options
     * @param bool $failOnNotFound
     * @return Model|null|mixed
     * @throws ModelNotFoundException
     */
    protected function firstWith(array $conditions, array $options = [], $failOnNotFound = false)
    {
        $method = $failOnNotFound ? 'firstOrFail' : 'first';

        return $this->parserResult($this->newQueryWithOptions($options)->where($conditions)->{$method}());
    }

    /**
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Builder|Builder
     */
    protected function newQueryWithOptions(array $options = [])
    {
        // default order by
        if (!isset($options['orderBy'])) {
            $options['orderBy'] = 'id:desc';
        }

        /** @var \Illuminate\Database\Eloquent\Builder|Builder $query */
        $query = $this->model()->newQuery();

        foreach (explode(',', $options['orderBy']) as $order) {
            list($column, $direction) = explode(':', $order);

            $query->orderBy($column, $direction);
        }

        if ($with = array_get($options, 'with')) {
            $query->with($with);
        }

        if (($limit = array_get($options, 'limit')) !== null) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Builder
     */
    protected function newQuery()
    {
        return $this->model()->newQuery();
    }
    
    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|Model|Builder|null|object
     */
    public function findOrNew($id)
    {
        $primaryKey = $this->model()->getKeyName();
        $find =  $this->newQueryWithOptions()->where($primaryKey, $id)->first();
        if (!$id) {
            return $this->model();
        }
        return $find;
    }

    protected function parserResult($result)
    {
        if ($this->transformable && $this->transformer instanceof ModelFractal) {
            return $this->transformer->transform($result);
        }

        return $result;
    }

    /**
     * @param $id
     * @param $userId
     * @return Model | null
     */
    public function findMy($id, $userId)
    {
        $model = $this->findById($id, true);

        if ($model->user_id != $userId) {
            throw new ModelNotFoundException();
        }

        return $model;
    }
}
