<?php

namespace QUI\Requirements\Tests\Database;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Version
 *
 * @package QUI\Requirements\Tests\Database
 */
class Version extends Test
{

    /**
     * @var string
     */
    protected $identifier = "database.version";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        if (!class_exists("\QUI")) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        if (!class_exists("\QUI\Database\DB")) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        $driver = \QUI::getDataBase()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $version = \QUI::getDataBase()->getPDO()->getAttribute(\PDO::ATTR_SERVER_VERSION);

        $requiredDrivers = [
            "mysql" => "5.6"
        ];

        if (!isset($requiredDrivers[$driver])) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get("requirements.error.mysql.version.incompatible.driver")
            );
        }

        $required = $requiredDrivers[$driver];

        $matches = [];
        preg_match("~([0-9]+\.[0-9]+\.[0-9]+)~", $version, $matches);

        if (!isset($matches[1])) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        $version = $matches[1];

        if (version_compare($version, $required, "<")) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get("requirements.error.mysql.version.incompatible.version")
            );
        }

        $okMessage = Locale::getInstance()->get("requirements.message.version.ok");
        $okMessage = str_replace("%VERSION%", $version, $okMessage);
        $okMessage = str_replace("%REQUIRED_VERSION%", $required, $okMessage);

        return new TestResult(TestResult::STATUS_OK, $okMessage);
    }
}
