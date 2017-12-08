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
        echo str_pad($Test->getName() . ": ", 20, " ", STR_PAD_RIGHT);
        // $Test->getResult() executes the test and return the Testresult Object
        echo str_pad($Test->getResult()->getStatusHumanReadable(), 20, " ", STR_PAD_RIGHT);
        echo " ==> ";
        // We are using getMessageRaw because TestResult::getMessage() could contain html tags
        echo str_pad($Test->getResult()->getMessageRaw(), 25, " ", STR_PAD_RIGHT);
        echo " | ";
        echo str_pad($Test->getDescrptionRaw(), 15, " ", STR_PAD_RIGHT);
        echo PHP_EOL;
    }
}
