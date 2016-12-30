<?php

namespace Llama\Database\Eloquent;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Llama\Database\Eloquent\Relations\BelongsToMany;
use Llama\Database\Eloquent\Relations\HasManyThrough;

trait ModelTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param QueryBuilder $query
     *
     * @return EloquentBuilder|static
     */
    public function newEloquentBuilder($query)
    {
        return new EloquentBuilder($query);
    }
}
