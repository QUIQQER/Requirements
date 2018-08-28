<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Curl extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.modules.curl";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!function_exists('curl_version') && !function_exists('curl_init')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.curl.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
