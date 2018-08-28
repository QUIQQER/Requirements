<?php

namespace QUI\Requirements\Tests\Webserver;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Headers
 *
 * @package QUI\Requirements\Tests\Webserver
 */
class Headers extends Test
{
    /**
     * @var string
     */
    protected $identifier = "webserver.headers";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (array_key_exists('HTTP_MOD_HEADERS', $_SERVER)) {
            return new TestResult(TestResult::STATUS_OK);
        }

        if (getenv('HTTP_MOD_HEADERS') == 'On') {
            return new TestResult(TestResult::STATUS_OK);
        }

        // test with apache modules
        if (function_exists('apache_get_modules')) {
            if (in_array('mod_headers', apache_get_modules())) {
                return new TestResult(TestResult::STATUS_OK);
            }
            
            return new TestResult(
                TestResult::STATUS_WARNING,
                Locale::getInstance()->get("requirements.error.webserver.headers.missing")
            );
        }

        // phpinfo test
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();

        if (strpos('mod_headers', $phpinfo) !== false) {
            return new TestResult(TestResult::STATUS_OK);
        }

        return new TestResult(TestResult::STATUS_UNKNOWN);
    }
}
