<?php

namespace Maxonfjvipon\Elegant_Elephant\Logical;

use Maxonfjvipon\Elegant_Elephant\Arrayable;
use Maxonfjvipon\Elegant_Elephant\Arrayable\ArrayableOf;
use Maxonfjvipon\Elegant_Elephant\Logical;

/**
 * In array of.
 * @package Maxonfjvipon\Elegant_Elephant\Logical
 */
final class ContainsIn implements Logical
{
    /**
     * @var Arrayable $arrayable
     */
    private Arrayable $arrayable;

    /**
     * @var mixed $needle
     */
    private mixed $needle;

    /**
     * @var bool $strict
     */
    private bool $strict;

    /**
     * Ctor wrap.
     * @param array $arr
     * @param mixed $needle
     * @param bool $strict
     * @return ContainsIn
     */
    public static function array(array $arr, mixed $needle, bool $strict = false): ContainsIn
    {
        return ContainsIn::arrayable(ArrayableOf::array($arr), $needle, $strict);
    }

    /**
     * Ctor wrap.
     * @param Arrayable $arr
     * @param mixed $needle
     * @param bool $strict
     * @return ContainsIn
     */
    public static function arrayable(Arrayable $arr, mixed $needle, bool $strict = false): ContainsIn
    {
        return new self($arr, $needle, $strict);
    }

    /**
     * Ctor.
     * @param Arrayable $arrayable
     * @param mixed $needle
     * @param bool $strict
     */
    public function __construct(Arrayable $arrayable, mixed $needle, bool $strict = false)
    {
        $this->arrayable = $arrayable;
        $this->needle = $needle;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function asBool(): bool
    {
        return in_array($this->needle, $this->arrayable->asArray(), $this->strict);
    }
}