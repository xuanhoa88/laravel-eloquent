<?php

namespace Llama\Database\Eloquent;

trait ModelTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return EloquentBuilder|static
     */
    public function newEloquentBuilder($query)
    {
        return new EloquentBuilder($query);
    }
}
