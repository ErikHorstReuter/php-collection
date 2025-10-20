<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;

use ArrayAccess;


class Collection extends AbstractCollection implements ArrayCollectionInterface
{

    private array $items = [];

    protected function &items(): array|ArrayAccess
    {
        return $this->items;
    }

    public function __construct(iterable $items = [])
    {
        if (gettype($items) === 'array') {
            $this->items = $items;
        } else {
            foreach ($items as $item) {
                $this->items[] = $item;
            }
        }
    }
}
