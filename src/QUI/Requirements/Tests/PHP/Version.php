<?php

namespace QUI\Requirements\Tests\PHP;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Version
 *
 * @package QUI\Requirements\Tests\System
 */
class Version extends Test
{

    protected $identifier = "php.version";


    protected function run()
    {
        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
    }
}
