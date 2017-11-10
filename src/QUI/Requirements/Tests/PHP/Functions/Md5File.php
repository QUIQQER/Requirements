<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class Md5File extends Test
{

    protected $identifier = "php.functions.md5file";


    protected function run()
    {
        if (!function_exists('md5_file')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.md5file.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}