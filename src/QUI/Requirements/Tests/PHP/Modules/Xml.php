<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Xml extends Test
{

    protected $identifier = "php.modules.xml";


    protected function run()
    {
        if (!extension_loaded('xml')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.xml.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
