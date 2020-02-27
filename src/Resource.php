<?php
namespace JoeCianflone\InertiaResource;

use Illuminate\Support\Collection;
use JoeCianflone\InertiaResource\ResourceLinks;
use JoeCianflone\InertiaResource\ResourceBuilder;

class Resource {

    private Collection $items;
    private array $resource;

    public function __construct()
    {

    }

    /**
     * Will take all the resource information you give it and do
     * all the necessary transformations
     *
     * @param Collection $items
     * @return array
     */
    public function transform(array $items): array
    {
        $this->items = collect($items);

        $transformer = new ResourceBuilder(new ResourceLinks(collect(static::links())));
        $transformer->setMeta(static::meta());
        $transformer->setData($this->items);

        return $transformer->get();
    }

    /**
     * get the value for a link, if necessary, hydrate
     *
     * @param string $key
     * @param mixed ...$hydrateWith
     * @return string|null
     */
    public static function link(string $key, ...$hydrateWith): ?string
    {
        $links = static::links();

        if (! array_key_exists($key, $links)) {
            return null;
        }

        $link = $links[$key];

        if (count($hydrateWith) > 0) {
            preg_match_all('/\{[\w\-]+\}/', $link, $output);
            
            for ($i = 0; $i < count($output[0]); $i++) {
              $link = str_replace($output[0][$i], $hydrate[$i], $link);
            }            
        }

        return $link;
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
