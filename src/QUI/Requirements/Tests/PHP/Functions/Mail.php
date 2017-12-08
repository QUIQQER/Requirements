<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class Mail extends Test
{

    protected $identifier = "php.functions.mail";


    protected function run()
    {
        if (!function_exists('mail')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.functions.mail.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
