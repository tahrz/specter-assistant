<?php

declare(strict_types=1);

namespace SpecterAssistant\Services;

use SpecterAssistant\Parameters\Parameter;

final class Core
{
    private const SLEEP_MS = 500000;
    private const TELEGRAM_API_URL = 'https://api.telegram.org/bot';

    public function __construct(
        private Config $config,
        private InteractHelper $interactHelper
    )
    {
    }

    public function handle(Parameter $parameter)
    {
        $this->config->setup($parameter);
        $this->interactHelper->matchArgs($parameter);

        $lastUpdateId = $this->getLastUpdateId();

        usleep($this->config->getDelay());

        while(true) {
            $update = $this->sendTelegramRequest('getUpdates', ['offset' => $lastUpdateId]);

            if (empty($update['result']) === false) {
                $this->sendUpdate($update['result'][0]);
                $lastUpdateId = (int)$update['result'][0]['update_id'];
                $lastUpdateId++;
                $this->interactHelper->renderLog($lastUpdateId, json_encode($update['result'][0]));
            }

            usleep(self::SLEEP_MS);
        }
    }

    protected function sendTelegramRequest(string $method, array $params): array
    {
        $token = $this->config->getToken();
        $url = self::TELEGRAM_API_URL . "$token/$method";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    protected function sendUpdate(array $update): void
    {
        $ch = curl_init($this->config->getUrl());
        curl_setopt($ch, CURLOPT_POSTFIELDS, \json_encode($update));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        curl_exec($ch);
        curl_close($ch);
    }

    protected function getLastUpdateId(?int $lastUpdateId = null): int
    {
        if ($lastUpdateId === null) {
            $response = $this->sendTelegramRequest(
                method: 'getUpdates',
                params: ['limit' => 1]
            );
        }

        return ($lastUpdateId ?? ($response['result'][0]['update_id'] ?? 0)) + 1;
    }

    public function throw(string $errorMessage): void
    {
        $this->interactHelper->throwException($errorMessage);
    }
}