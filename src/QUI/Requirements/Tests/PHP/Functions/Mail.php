<?php

namespace QUI\Requirements\Tests\PHP\Functions;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Mail
 *
 * @package QUI\Requirements\Tests\PHP\Functions
 */
class Mail extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.functions.mail";

    /**
     * @return TestResult
     * @throws \Exception
     */
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
