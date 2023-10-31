<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters\Actions;

use SpecterAssistant\Enums\Style\TextColor;

final class Basic
{
    public function run(): void
    {
        echo sprintf(
            "\n\n%sExecution with parameters from specter-assistant.neon%s\n\n\n",
            TextColor::GREEN->value,
            TextColor::RESET->value
        );
    }
}