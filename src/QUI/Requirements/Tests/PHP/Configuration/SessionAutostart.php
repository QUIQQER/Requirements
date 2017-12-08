<?php

namespace QUI\Requirements\Tests\PHP\Configuration;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

class SessionAutostart extends Test
{
    protected $identifier = "php.configuration.sessionautostart";

    protected function run()
    {
        $requiredValue = "0";
        $currentValue  = ini_get("session.auto_start");

        if ($currentValue != $requiredValue) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get("requirements.error.session.autostart.enabled")
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
