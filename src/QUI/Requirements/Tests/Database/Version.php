<?php

namespace QUI\Requirements\Tests\Database;


use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

class Version extends Test
{

    protected $identifier = "database.version";


    protected function run()
    {
        if (!class_exists("\QUI")) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        if (!class_exists("\QUI\Database\DB")) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        $driver  = \QUI::getDataBase()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $version = \QUI::getDataBase()->getPDO()->getAttribute(\PDO::ATTR_SERVER_VERSION);

        $requiredDrivers = array(
            "mysql" => "5.6"
        );

        if (!isset($requiredDrivers[$driver])) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get("requirements.error.mysql.version.incompatible.driver")
            );
        }

        $required = $requiredDrivers[$driver];

        $matches = array();
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

        return new TestResult(TestResult::STATUS_OK);
    }
}
