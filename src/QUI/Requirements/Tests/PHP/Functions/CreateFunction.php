<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class CreateFunction extends Test
{

    protected $identifier = "php.functions.createfunction";


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
