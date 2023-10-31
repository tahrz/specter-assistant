<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters\Actions;

use SpecterAssistant\Enums\Style\TextColor;

final class Help
{
    public function run(): never
    {
        $result = TextColor::CYAN->value . "Specter Assistant 1.0\n\n" . TextColor::RESET->value;

        $result .= sprintf(
            "%sUsage:%s\nvendor/bin/specter %s[options]%s\n\n",
            TextColor::GREEN->value,
            TextColor::RESET->value,
            TextColor::YELLOW->value,
            TextColor::RESET->value
        );

        $result .= sprintf(
            "  %s--help%s                              Display this help message\n",
            TextColor::GREEN->value,
            TextColor::RESET->value
        );

        $result .= sprintf(
            "  %s--dynamic%s %s<host> <delay> <token>%s    Run the dynamic command with host and bot token\n",
            TextColor::GREEN->value,
            TextColor::RESET->value,
            TextColor::MAGENTA->value,
            TextColor::RESET->value
        );

        echo $result;

        exit(0);
    }
}