<?php

namespace App\Base\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;

abstract class AbstractResource extends JsonResource
{
    protected $only = [];

    /**
     * @var string
     */
    protected string $channel;

    /**
     * @var string
     */
    protected string $language;

    /**
     * The resource data array.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Set the singular item.
     *
     * @param  mixed  $resource
     * @return $this
     */
    public function item($resource): AbstractResource
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Set the only fields we want to return.
     *
     * @param array $fields
     * @return $this
     */
    public function only(array $fields = []): AbstractResource
    {
        if ($fields instanceof Collection) {
            $fields = $fields->toArray();
        } elseif (is_string($fields)) {
            $fields = explode(',', $fields);
        }
        $this->only = collect($fields);

        return $this;
    }

    /**
     * Set the channel we want to use.
     *
     * @param string $channel
     * @return $this
     */
    public function channel(string $channel): AbstractResource
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set the language to use.
     *
     * @param string $language
     * @return $this
     */
    public function language(string $language): AbstractResource
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param array $only
     * @return void
     */
    public function __construct($resource, array $only = [])
    {
        $this->resource = $resource;
        $this->only = collect($only);
    }

    public function toArray($request)
    {
        $attributes = array_merge($this->payload(), $this->custom_attributes ?? []);

        if ($request->full_response) {
            $attributes = array_merge($attributes, [
                'attribute_data' => $this->attribute_data,
            ]);
            foreach ($this->optional() as $key => $value) {
                $attributes[$key] = $value;
            }
        } else {
            $attributes = array_merge($attributes, $this->map($this->attribute_data ?? []));
            foreach ($this->optional() as $key => $value) {
                $attributes[$key] = $this->when($request->{$key}, $value);
            }
        }

        $attributes = array_merge($attributes, $this->includes());
        $attributes = $this->handleOnlyRequestField($attributes);
        return $this->handleExceptRequestField($attributes);
    }

    protected function handleOnlyRequestField($attributes): array
    {
        if (! request()->filled('only')) {
            return $attributes;
        }

        $fields = explode(',', request()->get('only'));

        if (empty($fields)) {
            return $attributes;
        }

        return collect($attributes)->only($fields)->toArray();
    }

    protected function handleExceptRequestField($attributes): array
    {
        if (! request()->filled('except')) {
            return $attributes;
        }

        $fields = explode(',', request()->get('except'));

        if (empty($fields)) {
            return $attributes;
        }

        return collect($attributes)->except($fields)->toArray();
    }

    protected function relationLoaded($relation): bool
    {
        if ($this->whenLoaded($relation) instanceof MissingValue) {
            return false;
        }

        return true;
    }

    protected function include($relation, $resource)
    {
        if ($relation instanceof Model) {
            return [
                'data' => new $resource($relation),
            ];
        }

        return $this->when($this->relationLoaded($relation), function () use ($relation, $resource) {
            return ['data' => new $resource($this->whenLoaded($relation))];
        });
    }

    /**
     * The included resources.
     *
     * @return array
     */
    public function includes(): array
    {
        return [];
    }

    /**
     * Define optional attributes.
     *
     * @return array
     */
    public function optional(): array
    {
        return [];
    }

    /**
     * Map the attributes.
     *
     * @param  array  $data
     * @return array
     */
    protected function map($data): array
    {
        if (empty($data)) {
            return [];
        }
        $modified = [];
        foreach ($data as $field => $value) {
            if ($this->only->count() && ! $this->only->contains($field)) {
                continue;
            }
            $modified[$field] = $this->resource->attribute(
                $field,
                $this->channel,
                $this->language
            );
        }

        return $modified;
    }

    /**
     * Create new anonymous resource collection.
     *
     * @return AnonymousResourceCollection
     */
    public function respondWithCollection(): AnonymousResourceCollection
    {
        return new AnonymousResourceCollection($this->resource, get_called_class());
    }
}
