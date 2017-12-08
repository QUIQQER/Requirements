<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class ParseIniFile extends Test
{

    protected $identifier = "php.functions.parseinifile";


    protected function run()
    {
        if (!function_exists('parse_ini_file')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.parseinifile.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
