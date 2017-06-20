<?php

namespace QUI\Requirements\Tests\Webserver;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

class Rewrite extends Test
{
    protected $identifier = "webserver.rewrite";

    protected function run()
    {
        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
    }
}
