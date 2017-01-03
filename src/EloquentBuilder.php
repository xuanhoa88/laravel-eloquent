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
     * @param  array|string  $relations
     * @param string $type
     * @param bool   $where
     *
     * @return EloquentBuilder
     */
    public function join($relations, $type = 'inner', $where = false)
    {
    	if (is_string($relations)) {
    		$relations = [$relations];
    	}
    	
    	foreach ($relations as $relation) {
	        $relation = $this->getRelation($relation);
	
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
    	}

        $this->query->addSelect($this->model->getTable() . '.*');

        return $this;
    }

    /**
     * Add a "join where" clause to the query.
     *
     * @param  array|string  $relations
     * @param string $type
     *
     * @return EloquentBuilder|static
     */
    public function joinWhere($relations, $type = 'inner')
    {
        return $this->join($relations, $type, true);
    }

    /**
     * Add a left join to the query.
     *
     * @param  array|string  $relations
     *
     * @return EloquentBuilder|static
     */
    public function leftJoin($relations)
    {
        return $this->join($relations, 'left');
    }

    /**
     * Add a "join where" clause to the query.
     *
     * @param  array|string  $relations
     *
     * @return EloquentBuilder|static
     */
    public function leftJoinWhere($relations)
    {
        return $this->joinWhere($relations, 'left');
    }

    /**
     * Add a right join to the query.
     *
     * @param  array|string  $relations
     *
     * @return EloquentBuilder|static
     */
    public function rightJoin($relations)
    {
        return $this->join($relations, 'right');
    }

    /**
     * Add a "right join where" clause to the query.
     *
     * @param  array|string  $relations
     *
     * @return EloquentBuilder|static
     */
    public function rightJoinWhere($relations)
    {
        return $this->joinWhere($relations, 'right');
    }

    /**
     * Add a "cross join" clause to the query.
     *
     * @param  string  $relation
     * @return EloquentBuilder|static
     */
    public function crossJoin($relations)
    {
        return $this->join($relations, 'cross');
    }
}
