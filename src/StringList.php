<?php

namespace StrannyiTip\Helper\Type;

use ArrayAccess;
use Countable;
use Iterator;
use StrannyiTip\Helper\Type\Exception\IndexIsNotInteger;

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
     * String list.
     *
     * @param SimpleString|string ...$args String or string list
     */
    public function __construct(SimpleString|string ...$args)
    {
        $this->position = 0;
        foreach ($args as $arg) {
            $this->container[] = $arg instanceof SimpleString ? $arg : new SimpleString($arg);
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
        return $this->container[$offset] ?? null;
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
}