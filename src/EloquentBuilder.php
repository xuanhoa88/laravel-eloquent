<?php

namespace Llama\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EloquentBuilder extends Builder
{
    /**
     * Add a join clause to the query.
     *
     * @param string $relation
     * @param string $type
     * @param bool   $where
     *
     * @return EloquentBuilder
     */
    public function join($relationName, $type = 'inner', $where = false)
    {
        $relation = $this->getRelation($relationName);

        if ($relation instanceof BelongsTo) {
            $this->query->join(
                $relation->getRelated()->getTable(),
                $this->model->getTable() . '.' . $relation->getForeignKey(),
                '=',
                $relation->getRelated()->getTable() . '.' . $relation->getOtherKey(),
                $type,
                $where
            );
        } elseif ($relation instanceof BelongsToMany) {
            $this->query->join(
                $relation->getTable(),
                $relation->getQualifiedParentKeyName(),
                '=',
                $relation->getForeignKey(),
                $type,
                $where
            );

            $this->query->join(
                $relation->getRelated()->getTable(),
                $relation->getRelated()->getTable() . '.' . $relation->getRelated()->getKeyName(),
                '=',
                $relation->getOtherKey(),
                $type,
                $where
            );
        } else {
            $this->query->join(
                $relation->getRelated()->getTable(),
                $relation->getQualifiedParentKeyName(),
                '=',
                $relation->getForeignKey(),
                $type,
                $where
            );
        }

        $this->query->addSelect($this->model->getTable() . '.*');

        return $this;
    }

    /**
     * Add a "join where" clause to the query.
     *
     * @param string $relation
     * @param string $type
     *
     * @return EloquentBuilder|static
     */
    public function joinWhere($relation, $type = 'inner')
    {
        return $this->join($relation, $type, true);
    }

    /**
     * Add a left join to the query.
     *
     * @param string $relation
     *
     * @return EloquentBuilder|static
     */
    public function leftJoin($relation)
    {
        return $this->join($relation, 'left');
    }

    /**
     * Add a "join where" clause to the query.
     *
     * @param string $relation
     *
     * @return EloquentBuilder|static
     */
    public function leftJoinWhere($relation)
    {
        return $this->joinWhere($relation, 'left');
    }

    /**
     * Add a right join to the query.
     *
     * @param string $relation
     *
     * @return EloquentBuilder|static
     */
    public function rightJoin($relation)
    {
        return $this->join($relation, 'right');
    }

    /**
     * Add a "right join where" clause to the query.
     *
     * @param string $relation
     *
     * @return EloquentBuilder|static
     */
    public function rightJoinWhere($relation)
    {
        return $this->joinWhere($relation, 'right');
    }

    /**
     * Add a "cross join" clause to the query.
     *
     * @param  string  $relation
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function crossJoin($relation)
    {
        return $this->join($relation, 'cross');
    }
}
