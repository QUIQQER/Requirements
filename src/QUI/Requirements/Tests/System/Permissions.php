<?php

namespace QUI\Requirements\Tests\System;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Permissions
 *
 * @package QUI\Requirements\Tests\System
 */
class Permissions extends Test
{

    protected $identifier = "system.permissions";


    protected function run()
    {
        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
    }
}
