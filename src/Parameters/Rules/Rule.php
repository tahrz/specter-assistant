<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters\Rules;

interface Rule
{
    public function run(): bool;

    public function getErrorMessage(): string;

    public function getName(): string;

    /**
     * @return mixed[]
     */
    public function getValues(): array;
}