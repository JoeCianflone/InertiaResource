<?php
namespace JoeCianflone\InertiaResource;

use Illuminate\Support\Collection;
use JoeCianflone\InertiaResource\ResourceLinks;
use JoeCianflone\InertiaResource\ResourceBuilder;

class Resource {

    private Collection $items;
    private array $resource;

    public function __construct(array $items)
    {
        $this->items = collect($items);
        $this->transform(collect($items));
    }

    /**
     * Will take all the resource information you give it and do
     * all the necessary transformations
     *
     * @param Collection $items
     * @return void
     */
    public function transform(Collection $items): void
    {
        $transformer = new ResourceBuilder(new ResourceLinks(collect(static::links())));
        $transformer->setMeta(static::meta());
        $transformer->setData($items);

        $this->resource = $transformer->get();
    }

    /**
     * Gets a single value from the link key
     *
     * @param string $key
     * @return string|null
     */
    public static function link(string $key): ?string
    {
        $links = static::links();

        return $links[$key] ?? null;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->resource;
    }

    /**
     * @return array
     */
    public static function links(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function meta(): array
    {
        return [];
    }

}
