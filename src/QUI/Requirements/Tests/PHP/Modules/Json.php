<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Json extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.modules.json";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!function_exists('json_decode') && !function_exists('json_encode')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.json.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
