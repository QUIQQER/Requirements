<?php

namespace QUI\Requirements\Tests\Webserver;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Rewrite
 *
 * @package QUI\Requirements\Tests\Webserver
 */
class Rewrite extends Test
{
    /**
     * @var string
     */
    protected $identifier = "webserver.rewrite";

    /**
     * @return TestResult
     */
    protected function run()
    {
        if (php_sapi_name() == "cli") {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        if ($this->testRedirectByRequest()) {
            return new TestResult(TestResult::STATUS_OK);
        } else {
            return new TestResult(TestResult::STATUS_FAILED);
        }
    }

    /**
     * Executes a curl request against the server and checks if the request gets redirected properly.
     *
     * @return bool
     */
    protected function testRedirectByRequest()
    {
        if (php_sapi_name() == "cli") {
            return false;
        }

        $baseDir      = dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))));
        $htAccesspath = $baseDir."/.htaccess";

        $serverUrl = $_SERVER['HTTP_HOST'];

        if (file_exists($htAccesspath)) {
            rename($htAccesspath, $htAccesspath.".bak");
        }

        $checkValue = time();

        $htAccessContent = "RewriteEngine on".PHP_EOL;
        $htAccessContent .= "RewriteRule ^rewritetest$ rewritetest.html [NC]".PHP_EOL;

        file_put_contents($htAccesspath, $htAccessContent);
        file_put_contents($baseDir."/rewritetest.html", $checkValue);

        $ch = curl_init($serverUrl."/rewritetest");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $http_result = curl_exec($ch);
        curl_close($ch);

        $ch = curl_init("https://" . $serverUrl . "/rewritetest");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $https_result = curl_exec($ch);
        curl_close($ch);

        unlink($htAccesspath);
        unlink($baseDir."/rewritetest.html");
        if (file_exists($htAccesspath.".bak")) {
            rename($htAccesspath.".bak", $htAccesspath);
        }

        if ($http_result == $checkValue || $https_result == $checkValue) {
            return true;
        }

        return false;
    }
}
