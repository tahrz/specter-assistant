<?php

declare(strict_types=1);

namespace SpecterAssistant\Services;

use SpecterAssistant\Enums\Style\TextColor;
use SpecterAssistant\Parameters\Actions\Basic;
use SpecterAssistant\Parameters\Actions\Dynamic;
use SpecterAssistant\Parameters\Actions\Help;
use SpecterAssistant\Parameters\Actions\Init;
use SpecterAssistant\Parameters\Parameter;

final class InteractHelper
{
    public function matchArgs(Parameter $parameter): void
    {
        switch ($parameter->name) {
            case '--help':
                (new Help())->run();
            case '--init':
                (new Init())->run();
            case '--dynamic':
                (new Dynamic($parameter->arguments))->run();
                break;
            default:
                (new Basic())->run();
        }
    }

    public function throwException(string $message): never
    {
        echo sprintf(
            "\n%s%s%s\n",
            TextColor::RED->value,
            $message,
            TextColor::RESET->value
        );

        exit(0);
    }

    public function renderLog(int $updateId, string $updateBody): void
    {
        echo sprintf(
            "\n\n %s[Update ID: %s]%s\n%s",
            TextColor::YELLOW->value,
            $updateId,
            TextColor::RESET->value,
            $updateBody
        );
    }
}