<?php

namespace QUITests\Requirements;

use QUI;
use QUI\Requirements\Requirements;

/**
 * Class RequirementsTest
 *
 * @package QUITests\Requirements
 */
class RequirementsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test the PHP Memory Limit check
     */
    public function testPHPMemLimit()
    {
        # Save current memory limit
        $saved = ini_get('memory_limit');

        # Test 128M : Should return OK
        ini_set('memory_limit', '128M');
        $result = Requirements::testPHPMemLimit();
        $this->assertEquals(
            QUI\Requirements\TestResult::STATUS_OK,
            $result->getStatus()
        );

        # Test 1G : Should return OK
        ini_set('memory_limit', '1G');
        $result = Requirements::testPHPMemLimit();
        $this->assertEquals(
            QUI\Requirements\TestResult::STATUS_OK,
            $result->getStatus()
        );

        # Test 64M : Should return FAILED
        ini_set('memory_limit', '64M');
        $result = Requirements::testPHPMemLimit();
        $this->assertEquals(
            QUI\Requirements\TestResult::STATUS_FAILED,
            $result->getStatus()
        );

        # Test -1 (unlimited) : Should return OK
        ini_set('memory_limit', '-1');
        $result = Requirements::testPHPMemLimit();
        $this->assertEquals(
            QUI\Requirements\TestResult::STATUS_OK,
            $result->getStatus()
        );

        # Restore Memory Limit
        ini_set('memory_limit', $saved);
    }
}
