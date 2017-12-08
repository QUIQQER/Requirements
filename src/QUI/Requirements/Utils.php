<?php

namespace QUI\Requirements;

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
        $megaByte  =  round((int)$byte / 1048576);
        
        return (int)$megaByte;
    }
}
