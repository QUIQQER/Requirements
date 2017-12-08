<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Gzip extends Test
{

    protected $identifier = "php.modules.gzip";


    protected function run()
    {
        if (!function_exists('gzcompress')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.gzip.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
