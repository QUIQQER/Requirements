<?php

namespace QUI\Requirements\Tests\PHP\Functions;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class CreateFunction
 *
 * @package QUI\Requirements\Tests\PHP\Functions
 */
class CreateFunction extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.functions.createfunction";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!function_exists('create_function')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.createfunction.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
