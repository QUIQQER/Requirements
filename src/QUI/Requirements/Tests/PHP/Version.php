<?php

namespace QUI\Requirements\Tests\PHP;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Version
 *
 * @package QUI\Requirements\Tests\PHP
 */
class Version extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.version";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        $requiredVersion = '5.6';
        if (!version_compare(phpversion(), $requiredVersion, '>=')) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get("requirements.error.version.insufficient")
            );
        }


        $okMessage= Locale::getInstance()->get("requirements.message.version.ok");
        $okMessage = str_replace("%VERSION%", phpversion(), $okMessage);
        $okMessage = str_replace("%REQUIRED_VERSION%", $requiredVersion, $okMessage);
        return new TestResult(
            TestResult::STATUS_OK,
            $okMessage
        );
    }
}
