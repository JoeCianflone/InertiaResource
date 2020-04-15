<?php
namespace JoeCianflone\InertiaResource;

use Illuminate\Support\Collection;
use JoeCianflone\InertiaResource\ResourceLinks;

class ResourceBuilder {

    private $links;
    private $resource;

    public function __construct($links)
    {
        $this->links   = $links;
    }

    public function setMeta(array $data): void
    {
        $this->resource[config('inertia-resource.meta')] = array_merge($data, $this->metaLinks($this->links));
    }

    public function setData(Collection $data): void
    {
        $this->resource[config('inertia-resource.data')] = $data->map(function($item) use($data) {

            foreach($data->toArray(collect($item)) as $element) {
                $resourceItem = array_merge(
                    $element,
                    $this->itemLinks(collect($item), $this->links)
                );
            }

            return $resourceItem;

        })->toArray();
    }

    private function itemLinks(Collection $item, ResourceLinks $links): array
    {
        return [
            config('inertia-resource.links') => $this->links->except('index', 'create', 'store')->hydrate($item)->toArray()
        ];
    }

    private function metaLinks(ResourceLinks $links): array
    {
        return [
            config('inertia-resource.links') => $this->links->only('index', 'create', 'store')->toArray()
        ];
    }

    public function get(): array
    {
        return $this->resource;
    }
}
