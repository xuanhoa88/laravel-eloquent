<?php

namespace Llama\Database\Eloquent\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough as BaseHasManyThrough;

class HasManyThrough extends BaseHasManyThrough
{
    protected function setJoin($query = null)
    {
        $query = $query ?: $this->query;

        return parent::setJoin($query instanceof Builder ? $query->getQuery() : $query);
    }
}
