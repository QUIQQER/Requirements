<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class SetTimeLimit extends Test
{

    protected $identifier = "php.functions.settimelimit";


    protected function run()
    {
        if (!function_exists('set_time_limit')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.settimelimit.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
