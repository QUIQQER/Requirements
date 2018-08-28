<?php

namespace QUI\Requirements\Tests\PHP\Configuration;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Memorylimit
 * @package QUI\Requirements\Tests\PHP\Configuration
 */
class Memorylimit extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.configuration.memorylimit";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        $raw = ini_get('memory_limit');

        # Error while fetching value or value not set.
        if (empty($raw)) {
            return new TestResult(
                TestResult::STATUS_UNKNOWN,
                Locale::getInstance()->get("requirements.error.memorylimit.undetected")
            );
        }

        $raw  = trim($raw);
        $last = strtolower(substr($raw, -1));

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
            Locale::getInstance()->get("requirements.error.memorylimit.insufficient")
        );
    }
}
