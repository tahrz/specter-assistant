<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters;

final class Parameter
{
    /**
     * @param mixed[] $arguments
     */
    public function __construct(
        public readonly string $name,
        public readonly array $arguments
    )
    {
    }
}