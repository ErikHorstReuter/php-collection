<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;

use Core\GenericTrait\CountableTrait;
use Core\GenericTrait\IteratorTrait;
use Core\GenericTraits\GenericTrait\ArrayAccessTrait;


abstract class AbstractCollection implements CollectionInterface
{
    use ArrayAccessTrait;
    use CountableTrait;
    use IteratorTrait;

    abstract public function __construct(iterable $items = []);
}
