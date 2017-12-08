<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Dom extends Test
{

    protected $identifier = "php.modules.dom";


    protected function run()
    {
        if (!class_exists('DOMDocument')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.dom.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
