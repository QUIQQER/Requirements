<?php

namespace QUI\Requirements\Tests\Webserver;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class SSL
 *
 * @package QUI\Requirements\Tests\Webserver
 */
class SSL extends Test
{

    /**
     * @var string
     */
    protected $identifier = "webserver.ssl";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {

        if (!isset($_SERVER)) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        if (php_sapi_name() == "cli") {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        // Check https by protocol.
        if (isset($_SERVER['REQUEST_SCHEME'])) {
            if ($_SERVER['REQUEST_SCHEME'] == "https") {
                return new TestResult(TestResult::STATUS_OK);
            } else {
                return new TestResult(
                    TestResult::STATUS_WARNING,
                    Locale::getInstance()->get("requirements.error.webserver.ssl.disabled")
                );
            }
        }

       
        
        return new TestResult(TestResult::STATUS_UNKNOWN);
    }
}
