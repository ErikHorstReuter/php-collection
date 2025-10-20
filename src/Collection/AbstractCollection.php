<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;

use Core\GenericTraits\GenericTrait\{
    ArrayAccessTrait,
    CountableTrait,
    IteratorTrait,
};
use function array_chunk;
use function array_key_exists;
use function array_keys;
use function array_merge;
use function array_replace;
use function array_reverse;
use function array_slice;
use function array_unique;
use function array_values;
use function asort;
use function end;
use function in_array;
use function is_array;
use function iterator_to_array;
use function reset;
use function uasort;

abstract class AbstractCollection implements CollectionInterface
{
    use ArrayAccessTrait;
    use CountableTrait;
    use IteratorTrait;

    /**
     * @return array<int|string, mixed> by-ref
     */
    abstract protected function &items(): array;

    abstract public function __construct(iterable $items = []);

    public function remove(string|int $key): static
    {
        $items =& $this->items();
        unset($items[$key]);
        return $this;
    }

    public function contains(mixed $value, bool $strict = true): bool
    {
        return in_array($value, $this->items(), $strict);
    }

    public function toArray(): array
    {
        return $this->items();
    }

    public function map(callable $callback): static
    {
        $out = new static();
        $outItems =& $out->items();
        foreach ($this->items() as $k => $v) {
            $outItems[$k] = $callback($v, $k);
        }
        return $out;
    }

    public function filter(?callable $callback = null): static
    {
        $out = new static();
        $outItems =& $out->items();

        if ($callback === null) {
            foreach ($this->items() as $k => $v) {
                if ($v) {
                    $outItems[$k] = $v;
                }
            }
            return $out;
        }

        foreach ($this->items() as $k => $v) {
            if ($callback($v, $k)) {
                $outItems[$k] = $v;
            }
        }
        return $out;
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        $carry = $initial;
        foreach ($this->items() as $k => $v) {
            $carry = $callback($carry, $v, $k);
        }
        return $carry;
    }

    public function merge(iterable $items, bool $reindexNumeric = false): static
    {
        $right = is_array($items) ? $items : iterator_to_array($items, true);
        $left = $this->items();
        $merged = $reindexNumeric ? array_merge($left, $right) : array_replace($left, $right);
        return new static($merged);
    }

    public function slice(int $offset, ?int $length = null, bool $preserveKeys = false): static
    {
        return new static(array_slice($this->items(), $offset, $length, $preserveKeys));
    }

    public function chunk(int $size, bool $preserveKeys = false): static
    {
        return new static(array_chunk($this->items(), $size, $preserveKeys));
    }

    public function unique(int $flags = SORT_STRING): static
    {
        return new static(array_unique($this->items(), $flags));
    }

    public function reverse(bool $preserveKeys = true): static
    {
        return new static(array_reverse($this->items(), $preserveKeys));
    }

    public function sort(?callable $callback = null, int $flags = SORT_REGULAR): static
    {
        $items = $this->items();
        if ($callback) {
            uasort($items, $callback);
        } else {
            asort($items, $flags);
        }
        return new static($items);
    }

    public function keys(): static
    {
        return new static(array_keys($this->items()));
    }

    public function values(): static
    {
        return new static(array_values($this->items()));
    }

    public function isEmpty(): bool
    {
        return $this->items() === [];
    }

    public function using(callable $callback): mixed
    {
        return $callback($this);
    }

    public function hasKey(string|int $key): bool
    {
        return array_key_exists($key, $this->items());
    }

    public function get(int|string $key, mixed $default = null): mixed
    {
        $items = $this->items();
        return array_key_exists($key, $items) ? $items[$key] : $default;
    }

    public function set(int|string $key, mixed $value): static
    {
        $items =& $this->items();
        $items[$key] = $value;
        return $this;
    }

    public function first(): mixed
    {
        $items = $this->items();
        return $items === [] ? null : reset($items);
    }

    public function last(): mixed
    {
        $items = $this->items();
        return $items === [] ? null : end($items);
    }
}
