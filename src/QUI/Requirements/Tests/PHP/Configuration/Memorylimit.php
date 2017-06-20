<?php

namespace QUI\Requirements\Tests\PHP\Configuration;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class Memorylimit
 * @package QUI\Requirements\Tests\System
 */
class Memorylimit extends Test
{

    protected $identifier = "php.configuration.memorylimit";


    protected function run()
    {
        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
    }
}
