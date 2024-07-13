<?php

namespace App\Modules\Filter;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterService extends Controller
{
    public $softDelete = false;
    public $skip = 1;
    public $take = 10;

    // Get dynamic group list
    public function getGroups(Request $request, $model)
    {
        $group = json_decode($request->group, true);

        if (empty($group)) {
            return response()->json([
                'items' => [],
                'totalCount' => 0
            ]);
        }

        // Filter Group Where
        $where = null;
        $selector = $this->selector($group[0]['selector'], true, 'select');
        if (@$group[0]['search']) {
            $where = $this->selector(
                $group[0]['selector'],
                $group[0]['search'] ?? null,
                'where',
                'insensitive'
            );
        }

        if (isset($group[0]['filter'])) {
            $query = $this->setFilter(json_encode($group[0]['filter']), $model)->select($selector);
        } else {
            $query = $model::select($selector);
        }


        if ($where) {
            $query->where(...$where);
        }

        if ($request->has('skip') && $request->has('take')) {
            $query->skip(($this->skip - 1) * $this->take)
                ->take($this->take);
        }

        if ($this->softDelete ?? true) {
            $query->whereNull('deleted_at');
        }

        $items = $query->get();
        $totalCount = $model::count();
        $uniques = $this->getUniqueValues($items, $group[0]['selector']);
        $data = array_map(function ($item) {
            return ['key' => $item];
        }, $uniques);
        return [
            'data' =>  $data,
            'totalCount' => $totalCount
        ];
    }

    // Set filter method
    public function setFilter($filter, $query = null)
    {
        $items = json_decode($filter ?? '[]', true);
        foreach ($items as  $item) {
            $query = $query->where(function (Builder $filterQuery) use ($item) {
                switch ($item['type']) {
                    case 'SEARCH':
                        foreach ($item['columns'] as $key => $column) {
                            if ($key === 0) {
                                if (is_numeric($item['value']) && $column['type'] === 'number') {
                                    $filterQuery = $filterQuery->where($column['id'], '=', (int)$item['value']);
                                } elseif ($column['type'] === 'string') {
                                    $filterQuery = $filterQuery->where($column['id'], 'LIKE', '%' . $item['value'] . '%');
                                } elseif (in_array($item['value'], ['true', 'false']) && $column['type'] === 'boolean') {
                                    $filterQuery = $filterQuery->where($column['id'], '=', $item['value'] === 'true');
                                }
                                continue;
                            }

                            if (is_numeric($item['value']) && $column['type'] === 'number') {
                                $filterQuery = $filterQuery->orWhere($column['id'], '=', (int)$item['value']);
                            } elseif ($column['type'] === 'string') {
                                $filterQuery = $filterQuery->orWhere($column['id'], 'LIKE', '%' . $item['value'] . '%');
                            } elseif (in_array($item['value'], ['true', 'false']) && $column['type'] === 'boolean') {
                                $filterQuery = $filterQuery->orWhere($column['id'], '=', $item['value'] === 'true');
                            }
                        }
                        break;
                    case "SELECT":
                        foreach ($item['selecteds'] as $key => $select) {
                            if ($key === 0) {
                                $filterQuery = $filterQuery->where($item['id'], '=', $select);
                            } else {
                                $filterQuery = $filterQuery->orWhere($item['id'], '=', $select);
                            }
                        }
                        break;
                    case 'NUMBER':
                        $filterQuery = $filterQuery->whereBetween(
                            $item['id'],
                            [
                                @$item['min'] ?? 0,
                                @$item['max'] ?? 0
                            ]
                        );
                        break;
                    case 'DATE':
                        $filterQuery = $filterQuery->whereBetween(
                            $item['id'],
                            [
                                @$item['min'] ? new \DateTime($item['min']) : new \DateTime(),
                                @$item['max'] ? new \DateTime($item['max']) : new \DateTime()
                            ]
                        );
                        break;
                    default:
                        break;
                }
            });
        }

        return $query;
    }

    // Get where items
    public function getWhereFilter($options, $query = null)
    {
        return $this->getOrderBy($options, $this->setFilter(@$options["filter"], $query));
    }

    // Get selector object
    public function selector($selector, $value, $type = 'where', $mode = null)
    {
        if ($type === 'select') {
            return [$selector];
        } elseif ($type === 'where') {
            return $mode ? [$selector, 'LIKE', '%' . $value . '%'] : [$selector, '=', $value];
        } elseif ($type === 'order') {
            return [$selector, $value === 'asc' ? 'asc' : 'desc'];
        }
    }

    // Get unique values
    public function getUniqueValues($data, $selector)
    {
        $uniqueValues = [];
        foreach ($data as $item) {
            $selectedValue = $this->getValueBySelector($item, $selector);
            if ($selectedValue && !in_array($selectedValue, $uniqueValues)) {
                $uniqueValues[] = $selectedValue;
            }
        }
        return $uniqueValues;
    }

    // Get selector in value
    public function getValueBySelector($object, $selector)
    {
        $selectors = explode('.', $selector);
        $value = $object;
        foreach ($selectors as $prop) {
            if (!isset($value->$prop)) {
                return null;
            }
            $value = $value->$prop;
        }
        return $value;
    }

    //Get order by
    private function getOrderBy($options, $query)
    {
        $orderBy = [];
        try {
            $sortSplit = explode(',', @$options['sort']);
            $orderBy = $this->selector($sortSplit[0], $sortSplit[1], 'order');
        } catch (\Exception $e) {
            $orderBy = ['created_at', 'DESC'];
        }

        return  $query->orderBy(...$orderBy);
    }
}
