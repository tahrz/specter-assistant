<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters;

final class ValidationBag
{
    public function __construct(
        public readonly Parameter $parameter,
        public readonly ?string $errorMessage
    )
    {
    }
}