<?php

declare(strict_types=1);

namespace SpecterAssistant\Services;

use SpecterAssistant\Parameters\Parameter;
use SpecterAssistant\Parameters\ValidationBag;

final class Validator
{
    /**
     * @param string[] $rules
     */
    public function __construct(public readonly array $rules)
    {
    }

    public function validate(Parameter $param): ValidationBag
    {
        $bag = [];

        foreach ($this->rules as $ruleClassName) {
            $rule = new $ruleClassName($param->arguments);

            if ($rule->getName() === $param->name) {
                if ($rule->run() === false) {
                    $bag[$rule->getName()]['error'] = $rule->getErrorMessage();
                }
            }
        }

        return new ValidationBag(
            parameter: $param,
            errorMessage: $bag[$param->name]['error'] ?? null
        );
    }
}