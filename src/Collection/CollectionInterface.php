<?php declare(strict_types=1);

namespace Erik\PhpCollection\Collection;

use ArrayAccess;
use Countable;
use Iterator;


interface CollectionInterface extends ArrayAccess, Countable, Iterator {}
