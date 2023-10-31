<?php

declare(strict_types=1);

namespace SpecterAssistant\Parameters\Actions;

use SpecterAssistant\Enums\Style\TextColor;

final class Init
{
    private const CONFIG_FILE_NAME = 'specter-assistant.neon';
    private const SPECTER_ROOT_DIR = __DIR__ . '/../../../';
    private const CONFIG_PATH = self::SPECTER_ROOT_DIR . '../../../' . self::CONFIG_FILE_NAME;
    private const EXAMPLE_PATH = self::SPECTER_ROOT_DIR . self::CONFIG_FILE_NAME;

    public function run(): never
    {
        if (!file_exists(self::CONFIG_PATH)) {
            if (copy(self::EXAMPLE_PATH, self::CONFIG_PATH)) {
                echo sprintf(
                    "\n%sConfiguration file successful created%s\n\n",
                    TextColor::GREEN->value,
                    TextColor::RESET->value
                );

            } else {
                echo sprintf(
                    "\n%sFailed to copy%s\n\n",
                    TextColor::RED->value,
                    TextColor::RESET->value
                );
            }
        } else {
            echo sprintf(
                "\n%sAlready exists. Skipping copy...%s\n\n",
                TextColor::YELLOW->value,
                TextColor::RESET->value
            );
        }

        exit(0);
    }
}