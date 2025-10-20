<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;


class Collection extends AbstractCollection implements ArrayCollectionInterface
{
    /** @var array<int|string, mixed> */
    private array $items = [];

    /**
     * @return array<int|string, mixed> by-ref
     */
    protected function &items(): array
    {
        return $this->items;
    }

    public function __construct(iterable $items = [])
    {
        foreach ($items as $key => $value) {
            $this->items[$key] = $value;
        }
    }

    public function add(mixed $item, int|string|null $key = null): static
    {
        if ($key === null) {
            $this->items[] = $item;
        } else {
            $this->items[$key] = $item;
        }
        return $this;
    }

    public function addAll(iterable $items): static
    {
        foreach ($items as $key => $value) {
            $this->add($value, $key);
        }
        return $this;
    }
}
