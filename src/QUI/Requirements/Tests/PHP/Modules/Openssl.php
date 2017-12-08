<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Openssl extends Test
{

    protected $identifier = "php.modules.openssl";


    protected function run()
    {
        if (!extension_loaded('openssl')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.openssl.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
