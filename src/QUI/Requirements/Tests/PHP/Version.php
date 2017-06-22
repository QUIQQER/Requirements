<?php

namespace QUI\Requirements\Tests\PHP;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Version
 *
 * @package QUI\Requirements\Tests\PHP
 */
class Version extends Test
{

    protected $identifier = "php.version";


    protected function run()
    {
        if (version_compare(phpversion(), '5.6', '>=')) {
            return new TestResult(TestResult::STATUS_OK);
        }

        return new TestResult(
            TestResult::STATUS_FAILED,
            Locale::getInstance()->get("requirements.error.version.insufficient")
        );
    }
}
