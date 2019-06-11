<?php

namespace QUI\Requirements;

use QUI\Cache\Manager;
use QUI\Exception;
use QUI\Requirements\Tests\Test;
use QUI\System\Log;

class Utils
{
    const CACHE_KEY_SYSTEM_CHECK_RESULTS = 'quiqqer.requirements.systemcheck.results';

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
        $megaByte  =  round((int)$byte / 1048576);

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
        if (!$force) {
            try {
                return Manager::get(self::CACHE_KEY_SYSTEM_CHECK_RESULTS);
            } catch (Exception $Exception) {
                return [];
            }
        }

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
                $results[$Test->getIdentifier()] = $Test->getResult()->getStatus();
            }
        }

        try {
            Manager::set(self::CACHE_KEY_SYSTEM_CHECK_RESULTS, $results);
        } catch (\Exception $Exception) {
            Log::writeException($Exception);
        }

        return $results;
    }
}
