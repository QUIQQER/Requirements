<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Mbstring extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.modules.mbstring";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!extension_loaded('mbstring')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.mbstring.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
