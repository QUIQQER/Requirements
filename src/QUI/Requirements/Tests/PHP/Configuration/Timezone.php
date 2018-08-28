<?php

namespace QUI\Requirements\Tests\PHP\Configuration;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Timezone
 *
 * @package QUI\Requirements\Tests\PHP\Configuration
 */
class Timezone extends Test
{
    /**
     * @var string
     */
    protected $identifier = "php.configuration.timezone";

    /**
     * @return TestResult
     * @throws \Exception
     */
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
