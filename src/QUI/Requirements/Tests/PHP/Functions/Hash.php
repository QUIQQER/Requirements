<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class Hash extends Test
{

    protected $identifier = "php.functions.hash";


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
