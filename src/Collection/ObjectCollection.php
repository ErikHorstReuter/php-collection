<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;

use ArrayAccess;
use SplObjectStorage;


class ObjectCollection extends AbstractCollection implements ObjectCollectionInterface {
    private SplObjectStorage $items;


    protected function &items(): array|ArrayAccess
    {
        return $this->items;
    }

    public function __construct(?iterable $items = null)
    {
        if ($items === null) {
            $this->items = new SplObjectStorage();
        } elseif ($items instanceof SplObjectStorage) {
            $this->items = clone $items;
        } else {
            $this->items = new SplObjectStorage();
            foreach ($items as $item) {
                $this->items->attach($item);
            }
        }
    }
}
