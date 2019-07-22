<?php

namespace QUI\Requirements;

use QUI\Cache\Manager;
use QUI\Exception;
use QUI\Requirements\Tests\Test;
use QUI\System\Log;

class Utils
{
    /**
     * Parses the megabyte value from the human readable size notation.
     *
     * @param $humanReadableSize - in Example: 256M or 512K or 1G
     *
     * @return float
     */
    public static function parseMegaByteFromHumanReadable($humanReadableSize)
    {

        $raw  = trim($humanReadableSize);
        $last = strtolower(substr($raw, -1));

        # Convert shorthand notation to bytes
        switch ($last) {
            case 'g':
                $byte = substr($raw, 0, -1) * (pow(1024, 3));
                break;
            case 'm':
                $byte = substr($raw, 0, -1) * (pow(1024, 2));
                break;
            case 'k':
                $byte = substr($raw, 0, -1) * 1024;
                break;
            default:
                $byte = $raw;
        }

        // 1024 * 1024 = 1048576  ==> Bytes in one MegaByte
        $megaByte = round((int)$byte / 1048576);

        return (int)$megaByte;
    }


    /**
     * Returns the results of a (cached) system check.
     * If the "force"-parameter is not set the results are returned from cache.
     * If the "force"-parameter is set the system check is executed. This may take a lot of time!
     *
     * The result is an array with the system check's tests identifiers as keys and their result's status as value.
     *
     * @param boolean $force - Force a new system check
     *
     * @return array
     */
    public static function getSystemCheckResults($force = false)
    {
        try {
            $Requirements = new Requirements();
        } catch (\Exception $Exception) {
            Log::writeException($Exception);

            return [];
        }

        $tests = $Requirements->getAllTests();

        $results = [];
        foreach ($tests as $testGroup) {
            foreach ($testGroup as $Test) {
                /** @var Test $Test */
                $TestResult = $force ? $Test->getResult() : $Test->getResultFromCache();

                $Status = TestResult::STATUS_UNKNOWN;

                if (!is_null($TestResult)) {
                    $Status = $TestResult->getStatus();
                }

                $results[$Test->getIdentifier()] = $Status;
            }
        }

        return $results;
    }


    /**
     * Returns the results of a given array of tests in html format.
     * By default the results are taken from cache.
     * If the seconds parameter is set to false, the tests are executed and the live-results are used.
     * Executing all tests may take a lot of time!
     *
     * @param array   $allTests  - Array of tests (as returned by Requirements->getTests())
     * @param boolean $fromCache - Return results from cache or execute test to get live result?
     *
     * @return string
     */
    public static function htmlFormatTestResults($allTests, $fromCache = true)
    {
        $html = '<div class="check-table">';

        /** @var \QUI\Requirements\Tests\Test $Test */
        foreach ($allTests as $category => $Tests) {
            $html .= '<div class="system-check check-table-row">';
            $html .= '<div class="check-table-col check-table-col-test">';
            $html .= $category;
            $html .= '</div>';
            $html .= '<div class="check-table-col check-table-col-message">';
            $html .= '<ul>';
            foreach ($Tests as $Test) {
                $Result           = $fromCache ? $Test->getResultFromCache() : $Test->getResult();
                $testMessageClass = 'test-message';

                // extra class for checksum
                if ($Test->getIdentifier() == 'quiqqer.checksums') {
                    $testMessageClass .= ' test-message-checkSum';
                }

                switch ($Result->getStatus()) {
                    case TestResult::STATUS_OPTIONAL:
                    case TestResult::STATUS_OK:
                        $html .= '<li><span class="fa fa-check" title="';
                        break;

                    case TestResult::STATUS_FAILED:
                        $html .= '<li class="failed"><span class="fa fa-remove" title="';
                        break;

                    case TestResult::STATUS_UNKNOWN:
                    case TestResult::STATUS_WARNING:
                        $html .= '<li><span class="fa fa-exclamation-circle" title="';
                        break;
                }

                $html .= $Result->getStatusHumanReadable() . '"></span>';
                $html .= '<span class="test-name">' . $Test->getName() . '</span>';
                $html .= '<div class="' . $testMessageClass . '">';
                $html .= $Result->getMessage();
                $html .= '</div>';
            }
            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}
