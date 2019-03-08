<?php

namespace QUI\Requirements\Tests\PHP\Functions;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Hash
 *
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Hash extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.functions.hash";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!function_exists('hash')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.hash.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
