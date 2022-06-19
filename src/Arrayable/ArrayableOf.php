<?php

namespace Maxonfjvipon\Elegant_Elephant\Arrayable;

use Maxonfjvipon\Elegant_Elephant\Arrayable;
use Maxonfjvipon\Elegant_Elephant\Logical;
use Maxonfjvipon\Elegant_Elephant\Numerable;
use Maxonfjvipon\Elegant_Elephant\Text;
use Maxonfjvipon\OverloadedElephant\Overloadable;

/**
 * Arrayable of.
 * @package Maxonfjvipon\Elegant_Elephant\Arrayable
 */
final class ArrayableOf extends ArrayableIterable
{
    use Overloadable, ArrayableOverloaded;

    /**
     * @var array|Arrayable $array
     */
    private array|Arrayable $array;

    /**
     * @var bool $override
     */
    private bool $override;

    /**
     * @var array $rules
     */
    private array $rules;

    /**
     * Ctor wrap.
     * @param array|Arrayable $arr
     * @param bool $override
     * @param array $rules
     * @return ArrayableOf
     */
    public static function new(array|Arrayable $arr, bool $override = true, array $rules = []): ArrayableOf
    {
        return new self($arr, $override, $rules);
    }

    /**
     * Ctor.
     * @param array|Arrayable $arr
     * @param bool $override
     * @param array $rules
     */
    public function __construct(array|Arrayable $arr, bool $override = true, array $rules = [])
    {
        $this->array = $arr;
        $this->override = $override;
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     */
    public function asArray(): array
    {
        return ArrTernary::new(
            $this->override,
            fn() => $this->overload(
                $this->firstArrayableOverloaded($this->array),
                [[
                    'integer',
                    'double',
                    'boolean',
                    'string',
                    'array',
                    'null',
                    \Closure::class => fn(\Closure $closure) => call_user_func($closure),
                    Arrayable::class => fn(Arrayable $arrayable) => $arrayable->asArray(),
                    Numerable::class => fn(Numerable $numerable) => $numerable->asNumber(),
                    Text::class => fn(Text $text) => $text->asString(),
                    Logical::class => fn(Logical $logical) => $logical->asBool(),
                    ...$this->rules,
                ]]
            ),
            $this->array,
        )->asArray();
    }
}
