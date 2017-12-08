<?php

namespace QUI\Requirements\Tests\PHP\Configuration;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

class Timezone extends Test
{
    protected $identifier = "php.configuration.timezone";

    public function run()
    {
        $timezone = ini_get("date.timezone");

        if (empty($timezone)) {
            return new TestResult(
                TestResult::STATUS_WARNING,
                Locale::getInstance()->get("requirements.error.timezone.notset")
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}