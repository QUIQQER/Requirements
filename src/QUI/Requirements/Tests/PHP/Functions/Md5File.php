<?php

namespace QUI\Requirements\Tests\PHP\Functions;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Md5File
 *
 * @package QUI\Requirements\Tests\PHP\Functions
 */
class Md5File extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.functions.md5file";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!function_exists('md5_file')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.md5file.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
