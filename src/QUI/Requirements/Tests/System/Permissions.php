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

    /**
     * @var string
     */
    protected $identifier = "system.permissions";

    /**
     * @var string
     */
    protected $cmsDir;

    /**
     * @var string
     */
    protected $defaultFilePermission = "0744";
    /**
     * @var string
     */
    protected $defaultDirectoryPermission = "0755";

    /**
     * Permissions constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        if (defined('CMS_DIR')) {
            $this->cmsDir = CMS_DIR;
        } else {
            $this->cmsDir = dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))));
        }

        $this->cmsDir = rtrim($this->cmsDir, "/");
    }

    /**
     * @return TestResult
     * @throws \Exception
     */
    public function run()
    {
        /*
         * These directories must be writeable and it will get tested if they can be created, if they do not exist
         */
        $required = [
            "var/tmp",
            "var/cache",
            "var",
            "etc/",
            "media/",
            "packages/",
            "/"
        ];

        /*
         * These directories must be writeable, if they exist. 
         */
        $writeable = [
            "/templates/presets"
        ];

        $result = [];
        foreach ($required as $check) {
            $fullpath = $this->cmsDir . "/" . $check;

            $exists = is_dir($fullpath) || file_exists($fullpath);
            // File exists, check if it is writeable
            if ($exists && !is_writable($fullpath)) {
                $result[$check] = false;
                continue;
            }

            // Directory or file does not exists yet, try to create it
            if (!$exists && @mkdir($fullpath, 0755, true) === false) {
                $result[$check] = false;
                continue;
            }

            // Clean up after creating the directory
            if (!$exists && is_dir($fullpath)) {
                rmdir($fullpath);
            }

            $result[$check] = true;
        }

        // Test writeable directories
        foreach ($writeable as $check) {
            $fullpath = $this->cmsDir . "/" . $check;

            $exists = is_dir($fullpath) || file_exists($fullpath);

            if (!$exists) {
                continue;
            }

            // File exists, check if it is writeable
            if (!is_writable($fullpath)) {
                $result[$check] = false;
                continue;
            }

            $result[$check] = true;
        }

        // Build the test result
        $resultState = TestResult::STATUS_OK;
        // Build the base help message with the needed command to change file ownership
        $solution = Locale::getInstance()->get('requirements.error.system.permissions');

        $processUser = posix_getpwuid(posix_geteuid());
        $userName = $processUser['name'];

        $groupInfo = posix_getgrgid($processUser['gid']);
        $groupName = $groupInfo['name'];

        $solution = str_replace("%USER%", $userName, $solution);
        $solution = str_replace("%GROUP%", $groupName, $solution);
        $solution = str_replace("%PATH%", $this->cmsDir, $solution);

        // Add the corrupted files
        $message = "";
        foreach ($required as $check) {
            $writeable = $result[$check];
            if ($writeable) {
                $message .= "<span class='fa fa-check system-check'></span>&nbsp;" . $check . "<br />";
                continue;
            }

            //Error
            $message .= "<span class='fa fa-close system-check'></span>&nbsp;" . $check . "<br />";
            $resultState = TestResult::STATUS_FAILED;
        }

        if ($resultState == TestResult::STATUS_FAILED) {
            $message = $solution . $message;
        }
        
        return new TestResult($resultState, $message);
    }

    /**
     * Scans the given directory recursively
     *
     * @param $directory
     *
     * @return array
     */
    protected function scanDirRecursively($directory)
    {
        $result = [];

        $directory = rtrim($directory, "/");

        if (!is_readable($directory)) {
            return [];
        }

        foreach (scandir($directory) as $entry) {
            if ($entry == "." || $entry == "..") {
                continue;
            }

            if (is_dir($directory . "/" . $entry)) {
                $result = array_merge($result, $this->scanDirRecursively($directory . "/" . $entry));
                continue;
            }

            $result[] = $directory . "/" . $entry;
        }

        return $result;
    }
}
