<?php

namespace QUI\Requirements;

use QUI\Requirements\Tests\Test;

class Requirements
{

    /***
     * Requirements constructor.
     *
     * @param $langCode
     */
    public function __construct($langCode = "en")
    {
        Locale::getInstance()->setlanguage($langCode);
    }


    /**
     * Returns all available tests
     *
     * @return array
     */
    public function getAllTests()
    {
        return $this->getTestsFromDirectory(dirname(__FILE__) . "/Tests");
    }

    /**
     * @param $directory
     *
     * @return array
     */
    protected function getTestsFromDirectory($directory)
    {
        $tests = array();
        foreach (scandir($directory) as $entry) {
            if ($entry == "." || $entry == "..") {
                continue;
            }

            $fullpath = $directory . "/" . $entry;

            if (is_dir($fullpath)) {
                $tests = array_merge($tests, $this->getTestsFromDirectory($fullpath));
                continue;
            }

            $className = str_replace(dirname(dirname(dirname(__FILE__))), "", $fullpath);
            $className = str_replace(".php", "", $className);
            $className = str_replace("/", "\\", $className);

            if ($className == "\QUI\Requirements\Tests\Test") {
                continue;
            }

            if (!class_exists($className)) {
                continue;
            }


            $Test = new $className();


            if (!($Test instanceof Test)) {
                continue;
            }

            $tests[$Test->getGroupName()][] = $Test;
        }

        return $tests;
    }



//    /**
//     * Checks the PHP version. Requires PHP 5.5 or higher
//     *
//     * @return TestResult
//     */
//    private static function testPHPVersion()
//    {
//        if (version_compare(phpversion(), '5.6', '>=')) {
//            return new TestResult(TestResult::STATUS_OK);
//        }
//
//        return new TestResult(
//            TestResult::STATUS_FAILED,
//            Locale::getInstance()->get("requirements.error.version.insufficient")
//        );
//    }
//
//    /**
//     * Reads the php ini memory_limit and checks if it is 128m or higher.
//     *
//     * @return TestResult
//     */
//    private static function testPHPMemLimit()
//    {
//        $raw = ini_get('memory_limit');
//
//        # Error while fetching value or value not set.
//        if (empty($raw)) {
//            return new TestResult(
//                TestResult::STATUS_UNKNOWN,
//                Locale::getInstance()->get("requirements.error.memorylimit.undetected")
//            );
//        }
//
//        $raw  = trim($raw);
//        $last = strtolower(mb_substr($raw, -1));
//
//        # Convert shorthand notation to bytes
//        switch ($last) {
//            case 'g':
//                $limit = substr($raw, 0, -1) * (pow(1024, 3));
//                break;
//            case 'm':
//                $limit = substr($raw, 0, -1) * (pow(1024, 2));
//                break;
//            case 'k':
//                $limit = substr($raw, 0, -1) * 1024;
//                break;
//            default:
//                $limit = $raw;
//        }
//        $limit = $limit > 0 ? (round((int)$limit / 1048576)) : $limit;
//
//        if ($limit >= 256 || $limit == -1) {
//            return new TestResult(TestResult::STATUS_OK);
//        }
//
//        return new TestResult(
//            TestResult::STATUS_FAILED,
//            Locale::getInstance()->get("requirements.error.memorylimit.insufficient")
//        );
//    }
//
//    /**
//     * Checks if the PDO module is installed
//     *
//     * @return TestResult
//     */
//    private static function testPHPPDO()
//    {
//        if (!defined('PDO::ATTR_DRIVER_NAME')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.pdo.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the PHP DOM Module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testPHPDom()
//    {
//        if (!class_exists('DOMDocument')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.dom.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the PHP GetText module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testPHPGettext()
//    {
//        if (!function_exists('gettext')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.gettext.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the PHP Curl module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testPHPCurl()
//    {
//        if (!function_exists('curl_version') && !function_exists('curl_init')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.curl.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the PHP Json module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testPHPJson()
//    {
//        if (!function_exists('json_decode') && !function_exists('json_encode')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.json.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if a PHP Image Library module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testPHPImageLibs()
//    {
//        $libraries = array();
//
//        // ImageMagick PHP
//        if (class_exists('Imagick')) {
//            $libraries[] = 'PHP Image Magick';
//        }
//
//        // GD Lib
//        if (function_exists('imagecopyresampled')) {
//            $libraries[] = 'GD Lib';
//        }
//
//
//        if (empty($libraries)) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.imagelibs.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//
//    private static function testPHPTidy()
//    {
//        if (!class_exists('Tidy')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.tidy.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the PHP Gzip module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testPHPGzip()
//    {
//        if (!function_exists('gzcompress')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.gzip.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the PHP MbString module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testMbString()
//    {
//        if (!extension_loaded('mbstring')) {
//            return new TestResult(
//                TestResult::STATUS_FAILED,
//                Locale::getInstance()->get('requirements.error.module.gzip.missing')
//            );
//        }
//
//        return new TestResult(TestResult::STATUS_OK);
//    }
//
//    /** Checks if the Apache Rewrite  module is loaded
//     *
//     * @return TestResult
//     */
//    private static function testApacheRewrite()
//    {
//        if (array_key_exists('HTTP_MOD_REWRITE', $_SERVER)) {
//            return new TestResult(TestResult::STATUS_OK);
//        }
//
//        if (getenv('HTTP_MOD_REWRITE') == 'On') {
//            return new TestResult(TestResult::STATUS_OK);
//        }
//
//        // test with apache modules
//        if (function_exists('apache_get_modules') &&
//            in_array('mod_rewrite', apache_get_modules())
//        ) {
//            return new TestResult(TestResult::STATUS_OK);
//        }
//
//        // phpinfo test
//        ob_start();
//        phpinfo();
//        $phpinfo = ob_get_contents();
//        ob_end_clean();
//
//        if (strpos('mod_rewrite', $phpinfo) !== false) {
//            return new TestResult(TestResult::STATUS_OK);
//        }
//
//        return new TestResult(TestResult::STATUS_UNKNOWN);
//    }
}
