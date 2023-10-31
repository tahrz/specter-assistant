<?php

declare(strict_types=1);

namespace SpecterAssistant;

use Throwable;
use Exception;
use SpecterAssistant\Services\Core;
use SpecterAssistant\Parameters\Parameter;
use SpecterAssistant\Services\Validator;

/**
 * Warming! This tool only for development purposes.
 */
final class Application
{
    public function __construct(
        private readonly Validator $validator,
        private readonly Core $coreService
    )
    {
    }

    public function run(array $argv): int
    {
        try {
            $param = new Parameter(
                name: $argv[1] ?? $argv[0],
                arguments: count($argv) > 2 ? array_slice($argv, 2) : []
            );

            $dataBag = $this->validator->validate($param);

            if ($dataBag->errorMessage !== null) {
                throw new Exception($dataBag->errorMessage);
            }

            $this->coreService->handle($dataBag->parameter);
        } catch (Throwable $throwable) {
            $this->coreService->throw($throwable->getMessage());
        }

        return 0;
    }
}