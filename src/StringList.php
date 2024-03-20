<?php

namespace StrannyiTip\Helper\Type;

use ArrayAccess;
use Countable;
use Iterator;
use StrannyiTip\Helper\Type\Exception\IndexIsNotInteger;
use Stringable;

/**
 * String list.
 */
class StringList implements ArrayAccess, Iterator, Countable
{
    /**
     * Strings container.
     *
     * @var array
     */
    private array $container;

    /**
     * Iterator position.
     *
     * @var int
     */
    private int $position;

    /**
     * Enumeration separator.
     *
     * @var string|null
     */
    private ?string $separator = null;

    /**
     * @const string Default enumeration separator for fromEnumerationString() method. used if no done
     */
    private const DEFAULT_ENUMERATION_SEPARATOR = ',';

    /**
     * String list.
     *
     * @param Stringable|string ...$args String or string list
     */
    public function __construct(Stringable|string ...$args)
    {
        $this->position = 0;
        foreach ($args as $arg) {
            $this->container[] = $arg instanceof Stringable ? $arg : new SimpleString((string)$arg);
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): ?SimpleString
    {
        $founded_item = $this->container[$offset] ?? null;

        return $founded_item instanceof SimpleString ? $founded_item : new SimpleString((string)$founded_item);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_numeric($offset)) {
            throw new IndexIsNotInteger('Presented index not int. Only integer indexes allowed');
        }
        if (null == $offset) {
            $this->container[] = new SimpleString($value);
        } else {
            $this->container[$offset] = new SimpleString($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function current(): ?SimpleString
    {
        return $this->container[$this->position];
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function next(): void
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function key(): int
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function valid(): bool
    {
        return isset($this->container[$this->position]);
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function count(): int
    {
        return \count($this->container);
    }

    /**
     * Say use specific separator.
     *
     * @param Stringable|string $separator Separator
     *
     * @return StringList
     */
    public function useSeparator(Stringable|string $separator): StringList
    {
        $this->separator = (string)$separator;

        return $this;
    }

    /**
     * Fill container from enumerated string.
     *
     * @param Stringable|string $string Enumerated string e.g. "one, two, three"
     *
     * @return StringList
     */
    public function fromEnumerationString(Stringable|string $string): StringList
    {
        $this->container = \explode($this->separator ?? self::DEFAULT_ENUMERATION_SEPARATOR, $string);

        return $this;
    }
}