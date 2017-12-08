<?php

namespace QUI\Requirements\Tests\Database;


use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

class Connectivity extends Test
{

    protected $identifier = "database.connectivity";


    protected function run()
    {
        if (!class_exists("\QUI")) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        if (!class_exists("\QUI\Database\DB")) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }

        try {
            \QUI::getDataBase()->getNewPDO();
        } catch (\Exception $Exception) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get("requirements.error.mysql.connectivity") . "<br />" . $Exception->getMessage()
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
