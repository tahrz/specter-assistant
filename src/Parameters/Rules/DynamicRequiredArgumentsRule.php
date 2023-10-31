<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters\Rules;

use SpecterAssistant\Enums\Style\TextColor;

class DynamicRequiredArgumentsRule implements Rule
{
    private const NAME = '--dynamic';

    /**
     * @var string[]
     */
    private array $values = [];

    /**
     * @param mixed[] $args
     */
    public function __construct(private readonly array $args)
    {
    }

    public function run(): bool
    {
        if (isset($this->args[0]) &&
            isset($this->args[1]) &&
            isset($this->args[2])) {
            $host = $this->args[0];
            $delay = $this->args[1];
            $token = $this->args[2];

            $this->values = [(string)$host, (string)$delay, (string)$token];

            return true;
        }

        return false;
    }

    public function getErrorMessage(): string
    {
        return sprintf(
            "%sError: The --dynamic command requires host, delay and token values.%s\n",
            TextColor::RED->value,
            TextColor::RESET->value
        );
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}