<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters\Actions;

use SpecterAssistant\Enums\Style\TextColor;

final class Dynamic
{
    public function __construct(private readonly array $params)
    {
    }

    public function run(): void
    {
        echo sprintf(
            "\n\n%sDynamic command execution with host: %s%s%s, delay: %s%s%s and token: %s%s%s\n\n\n",
            TextColor::GREEN->value,
            TextColor::RESET->value . TextColor::MAGENTA->value,
            $this->params[0],
            TextColor::RESET->value . TextColor::GREEN->value,
            TextColor::RESET->value . TextColor::MAGENTA->value,
            $this->params[1],
            TextColor::RESET->value . TextColor::GREEN->value,
            TextColor::RESET->value . TextColor::MAGENTA->value,
            $this->params[2],
            TextColor::RESET->value
        );
    }
}