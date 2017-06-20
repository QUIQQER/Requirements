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
        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
    }
}
