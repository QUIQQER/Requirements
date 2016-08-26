<?php

namespace QUI\Requirements;

use QUI\Interfaces\System\Test;

class Requirements
{

    public static function runAll()
    {
        $results = array();

        # Test PHP Version
        $results[] = array(
            'name'   => 'PHP Version',
            'result' => self::testPHPVersion()
        );

        # Test PHP Memory Limit
        $results[] = array(
            'name'   => 'PHP Memory Limit > 128M',
            'result' => self::testPHPMemLimit()
        );

        # Test PHP Module PDO
        $results[] = array(
            'name'   => 'PHP PDO installed',
            'result' => self::testPHPPDO()
        );

        # Test PHP Module DOM
        $results[] = array(
            'name'   => 'PHP DOM installed',
            'result' => self::testPHPDom()
        );

        # Test PHP Module GetText
        $results[] = array(
            'name'   => 'PHP GetText support',
            'result' => self::testPHPGettext()
        );

        # Test PHP Module Curl
        $results[] = array(
            'name'   => 'PHP Curl support',
            'result' => self::testPHPCurl()
        );

        # Test PHP Module Json
        $results[] = array(
            'name'   => 'PHP Json support',
            'result' => self::testPHPJson()
        );

        # Test PHP Image Libraries
        $results[] = array(
            'name'   => 'PHP Image Libraries',
            'result' => self::testPHPImageLibs()
        );

        # Test PHP Tidy
        $results[] = array(
            'name'   => 'PHP Tidy Support',
            'result' => self::testPHPTidy()
        );

        # Test PHP GZip
        $results[] = array(
            'name'   => 'PHP Gzip Support',
            'result' => self::testPHPGzip()
        );

        # Test Apache rewrite
        $results[] = array(
            'name'   => 'Apache mod rewrite',
            'result' => self::testApacheRewrite()
        );

        return $results;
    }


    /**
     * Checks the PHP version. Requires PHP 5.3 or higher
     * @return TestResult
     */
    private static function testPHPVersion()
    {
        if (version_compare(phpversion(), '5.3', '<')) {
            return new TestResult(TestResult::STATUS_OK);
        }

        return new TestResult(
            TestResult::STATUS_FAILED,
            \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.version.insufficient')
        );
    }

    /**
     * Reads the php ini memory_limit and checks if it is 128m or higher.
     * @return TestResult
     */
    private static function testPHPMemLimit()
    {
        $raw = ini_get('memory_limit');

        # Error while fetching value or value not set.
        if (empty($raw)) {
            return new TestResult(
                TestResult::STATUS_UNKNOWN,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.memorylimit.undetected')
            );
        }

        $raw  = trim($raw);
        $last = strtolower(mb_substr($raw, -1));

        # Convert shorthand notation to bytes
        switch ($last) {
            case 'g':
                $limit = substr($raw, 0, -1) * (pow(1024, 3));
                break;
            case 'm':
                $limit = substr($raw, 0, -1) * (pow(1024, 2));
                break;
            case 'k':
                $limit = substr($raw, 0, -1) * 1024;
                break;
            default:
                $limit = $raw;
        }
        $limit = $limit > 0 ? (round((int)$limit / 1048576)) : $limit;

        if ($limit >= 128 || $limit == -1) {
            return new TestResult(TestResult::STATUS_OK);
        }

        return new TestResult(
            TestResult::STATUS_FAILED,
            \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.memorylimit.insufficient')
        );
    }

    /**
     * Checks if the PDO module is installed
     * @return TestResult
     */
    private static function testPHPPDO()
    {
        if (!defined('PDO::ATTR_DRIVER_NAME')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.pdo.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPDom()
    {
        if (!class_exists('DOMDocument')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.dom.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPGettext()
    {
        if (!function_exists('gettext')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.gettext.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPCurl()
    {
        if (!function_exists('curl_version') && !function_exists('curl_init')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.curl.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPJson()
    {
        if (!function_exists('json_decode') && !function_exists('json_encode')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.json.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPImageLibs()
    {
        $libraries = array();

        // ImageMagick PHP
        if (class_exists('Imagick')) {
            $libraries[] = 'PHP Image Magick';
        }

        // GD Lib
        if (function_exists('imagecopyresampled')) {
            $libraries[] = 'GD Lib';
        }

        if (empty($libraries)) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.imagelibs.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPTidy()
    {
        if (!class_exists('tidy')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.tidy.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testPHPGzip()
    {
        if (!function_exists('gzcompress')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.module.gzip.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    private static function testApacheRewrite()
    {
        if (array_key_exists('HTTP_MOD_REWRITE', $_SERVER)) {
            return new TestResult(TestResult::STATUS_OK);
        }

        if (getenv('HTTP_MOD_REWRITE') == 'On') {
            return new TestResult(TestResult::STATUS_OK);
        }

        // test with apache modules
        if (function_exists('apache_get_modules') &&
            in_array('mod_rewrite', apache_get_modules())
        ) {
            return new TestResult(TestResult::STATUS_OK);
        }

        // phpinfo test
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();

        if (strpos('mod_rewrite', $phpinfo) !== false) {
            return new TestResult(TestResult::STATUS_OK);
        }

        return new TestResult(TestResult::STATUS_UNKNOWN);
    }
}
