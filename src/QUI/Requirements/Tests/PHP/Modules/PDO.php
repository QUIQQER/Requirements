<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class PDO extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.modules.pdo";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!defined('PDO::ATTR_DRIVER_NAME')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.pdo.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
