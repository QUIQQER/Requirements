<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class SPL extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.modules.SPL";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!extension_loaded('SPL')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.spl.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
