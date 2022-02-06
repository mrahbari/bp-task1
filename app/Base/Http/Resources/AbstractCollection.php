<?php

namespace App\Base\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

abstract class AbstractCollection extends ResourceCollection
{
    protected $only = [];

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param array $only
     * @return void
     */
    public function __construct($resource, array $only = [])
    {
        parent::__construct($resource);
        $this->only = $only;
        $this->resource = $this->collectResource($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
        ];
    }

    /**
     * Map the given collection resource into its individual resources.
     *
     * @param mixed $resource
     * @return AbstractPaginator|Collection|MissingValue
     */
    protected function collectResource($resource)
    {
        if ($resource instanceof MissingValue) {
            return $resource;
        }

        $collects = $this->collects();
        if ($collects && ! $resource->first() instanceof $collects) {
            $collection = collect();
            $resource->each(function ($item) use ($collection, $collects) {
                $collection->push(
                    (new $collects($item))->only($this->only)
                );
            });
            $this->collection = $collection;
        } else {
            $collection = collect();
            $resource->each(function ($item) use ($collection, $collects) {
                $collection->push(
                    (new $collects($item))->only($this->only)
                );
            });
            $this->collection = $collection;
        }

        return $resource instanceof AbstractPaginator
                    ? $resource->setCollection($this->collection)
                    : $this->collection;
    }
}
