<?php

declare(strict_types=1);

namespace SpecterAssistant\Services;

use LogicException;
use Nette\Neon\Neon;
use SpecterAssistant\Parameters\Parameter;

final class Config
{
    private const CONFIG_DIR = __DIR__ . '/../../../../../specter-assistant.neon';

    protected string $token = '';
    protected string $url = '';
    protected int $delay = 250000;

    public function setup(Parameter $parameter): void
    {
        if ($parameter->name === '--dynamic') {
            $this->url = $parameter->arguments[0];
            $this->delay = (int)$parameter->arguments[1];
            $this->token = $parameter->arguments[2];
        } else if (file_exists(self::CONFIG_DIR)) {
            $data = Neon::decode(file_get_contents(self::CONFIG_DIR));

            if (isset($data['parameters']['url']) === false &&
                isset($data['parameters']['delay']) === false &&
                isset($data['parameters']['token']) === false) {
                throw new LogicException(
                    'Please make sure that config data is correct, or use --dynamic command'
                );
            }

            $this->url = $data['parameters']['url'];
            $this->delay = $data['parameters']['delay'];
            $this->token = $data['parameters']['token'];
        } else if ($parameter->name !== '--init' &&
            $parameter->name !== '--help') {
            throw new LogicException(
                'Config file not found, please run --init command or use --dynamic'
            );
        }
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDelay(): int
    {
        return (int)$this->delay;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}