<?php

/**
 * This example runs all available tests and prints their result to the console.
 */

require_once dirname(dirname(__FILE__)) . "/vendor/autoload.php";

// Initialize the Requirements object.
// Provide the language code 'de' for german language
$Requirements = new \QUI\Requirements\Requirements("de");

/**
 * @var string                          $groupName
 * @var  \QUI\Requirements\Tests\Test[] $Tests
 */
foreach ($Requirements->getAllTests() as $groupName => $Tests) {
    echo "===== " . $groupName . "=====" . PHP_EOL;

    foreach ($Tests as $Test) {
        echo $Test->getName();
        echo " : ";
        // $Test->getResult() executes the test and return the Testresult Object
        echo $Test->getResult()->getStatusHumanReadable();
        echo "==>";
        // We are using getMessageRaw because TestResult::getMessage() can contain html tags
        echo $Test->getResult()->getMessageRaw();
        echo PHP_EOL;
    }
}
