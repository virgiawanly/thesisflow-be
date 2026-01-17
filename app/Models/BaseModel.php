<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    /**
     * The attributes that are searchable in the query.
     *
     * @var array<int, string>
     */
    protected $searchables = [];

    /**
     * The columns that are sortable in the query.
     *
     * @var array<int, string>
     */
    protected $sortableColumns = [];

    /**
     * Scope a query to search for a query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $keyword
     * @param  array|string|null $searchableColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $keyword, $searchableColumns = null): Builder
    {
        if (!$keyword) {
            return $query;
        }

        $searchableColumns = is_string($searchableColumns)
            ? explode(',', $searchableColumns)
            : ($searchableColumns ?? []);

        $searchColumns = !empty($searchableColumns)
            ? array_intersect($this->searchables, $searchableColumns)
            : $this->searchables;

        $searchMethods = $this->getSearchMethods($searchableColumns);

        return $query->where(function ($query) use ($keyword, $searchColumns, $searchMethods) {
            // Search in basic columns
            foreach ($searchColumns as $searchable) {
                $query->orWhere($this->getTable() . '.' . $searchable, 'LIKE', "%{$keyword}%");
            }

            // Search using custom search methods
            foreach ($searchMethods as $method) {
                $query->orWhere(function ($query) use ($method, $keyword) {
                    $this->$method($query, $keyword);
                });
            }
        });
    }

    /**
     * Get all search methods that should be applied.
     *
     * @param array|null $searchableColumns
     * @return array
     */
    protected function getSearchMethods($searchableColumns = null): array
    {
        $methods = array_filter(
            get_class_methods($this),
            function ($method) {
                return strpos($method, 'search') === 0 && $method !== 'search';
            }
        );

        // If specific searchable columns are provided, filter methods
        if (!empty($searchableColumns)) {
            $methods = array_filter($methods, function ($method) use ($searchableColumns) {
                // Convert searchParent -> parent, searchParentName -> parent_name
                $column = Str::snake(substr($method, 6)); // Remove 'search' prefix
                return in_array($column, $searchableColumns);
            });
        }

        return array_values($methods);
    }

    /**
     * Scope a query to order by a column.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $orderBy
     * @param string|null $orderDirection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrder(Builder $query, string $orderBy, string $orderDirection = 'asc'): Builder
    {
        if (!empty($orderBy) && in_array($orderBy, $this->sortableColumns)) {
            return $query->orderBy($this->getTable() . '.' . $orderBy, $orderDirection);
        }

        return $query;
    }

    /**
     * Scope a query to filter the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (method_exists($this, $method = 'filter' . Str::ucfirst(Str::camel($key))) && !empty($value)) {
                $this->$method($query, $value);
            }
        }

        return $query;
    }
}
