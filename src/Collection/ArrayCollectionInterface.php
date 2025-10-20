<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;


use ArrayAccess;

interface ArrayCollectionInterface extends CollectionInterface
{
    function add(mixed $item, int|string|null $key = null): static;

    function addAll(iterable $items): static;
}
