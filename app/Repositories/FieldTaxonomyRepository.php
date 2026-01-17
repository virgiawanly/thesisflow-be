<?php

namespace App\Repositories;

use App\Models\FieldTaxonomy;

class FieldTaxonomyRepository extends BaseResourceRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new FieldTaxonomy();
    }

    /**
     * Get paginated nested resources.
     *
     * @param int $perPage
     * @param array $params
     * @param array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNestedList(int $perPage, array $params = [], array $relations = [])
    {
        $hasSearch = !empty($params['search']);

        // If there's a search query, only return items that match (including children)
        // Don't include parents that don't match
        if ($hasSearch) {
            // Find all matching taxonomies (including children)
            $matchingIds = $this->model
                ->when(method_exists($this->model, 'scopeSearch'), function ($query) use ($params) {
                    $query->search($params['search'] ?? '', $params['searchable_columns'] ?? []);
                })
                ->when(method_exists($this->model, 'scopeFilter'), function ($query) use ($params) {
                    $query->filter($params['filters'] ?? []);
                })
                ->pluck('id')
                ->toArray();

            if (empty($matchingIds)) {
                // No matches found, return empty paginated result
                return $this->model->whereRaw('1 = 0')->paginate($perPage);
            }

            // Return only the matching taxonomies with their nested children
            return $this->model
                ->whereIn('id', $matchingIds)
                ->with('nestedChildren')
                ->with($relations)
                ->when(method_exists($this->model, 'scopeOfOrder'), function ($query) use ($params) {
                    $query->ofOrder($params['order_by'] ?? 'id', $params['order_direction'] ?? 'asc');
                })
                ->paginate($perPage);
        }

        // No search query, return all root taxonomies with their nested children
        return $this->model
            ->whereNull('parent_id')
            ->with('nestedChildren')
            ->with($relations)
            ->when(method_exists($this->model, 'scopeOfOrder'), function ($query) use ($params) {
                $query->ofOrder($params['order_by'] ?? 'id', $params['order_direction'] ?? 'asc');
            })
            ->when(method_exists($this->model, 'scopeFilter'), function ($query) use ($params) {
                $query->filter($params['filters'] ?? []);
            })
            ->paginate($perPage);
    }

    /**
     * Get all parent IDs for the given taxonomy IDs.
     *
     * @param array $taxonomyIds
     * @return array
     */
    protected function getParentChainIds(array $taxonomyIds): array
    {
        $parentIds = [];
        $currentIds = $taxonomyIds;

        // Recursively get parent IDs until we reach the root
        while (!empty($currentIds)) {
            $parents = $this->model
                ->whereIn('id', $currentIds)
                ->whereNotNull('parent_id')
                ->pluck('parent_id')
                ->toArray();

            if (empty($parents)) {
                break;
            }

            $parentIds = array_merge($parentIds, $parents);
            $currentIds = $parents;
        }

        return array_unique($parentIds);
    }
}
