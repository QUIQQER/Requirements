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

    protected $identifier = "system.permissions";

    protected $cmsDir;

    protected $defaultFilePermission = "0744";
    protected $defaultDirectoryPermission = "0755";

    public function __construct($cmsDir)
    {
        parent::__construct();

        $this->cmsDir = rtrim($cmsDir, "/");
    }

    public function run()
    {

        // ==================================== //
        // Check folder permissions folders
        // ==================================== //
        $checks = array(//"var/cache/" => "0755",
        );

        $errors = array();

        // Check required permissions
        foreach ($checks as $file => $requiredPermission) {
            $fullPath = $this->cmsDir . "/" . $file;

            if (!file_exists($fullPath)) {
                continue;
            }

            $perm = substr(decoct(fileperms($fullPath)), -4);

            if ($perm != $requiredPermission) {
                $errors[] = Locale::getInstance()->get("test.message.error.permission.file", array(
                    "FILE"     => $file,
                    "CURRENT"  => $perm,
                    "REQUIRED" => $requiredPermission
                ));
            }
        }

        // ==================================== //
        // Check writeable folders
        // ==================================== //
        $requiredWritable = array(
            "", // Root diectory
            "var/",
            "packages/",
            "media/",
            "etc/"
        );

        /** @var string $file - Relative path within the CMS Directory */
        foreach ($requiredWritable as $file) {

            /** @var string $fullPath - Fullpath to the given directory/file */
            $fullPath = $this->cmsDir . "/" . $file;

            if (!file_exists($fullPath) && !is_dir($fullPath)) {
                continue;
            }

            if (!is_writable($fullPath)) {
                $errors[] = Locale::getInstance()->get("test.message.error.not.writeable.file", array(
                    "FILE" => $file
                ));
            }


//            // Scan the files and the subdirectories  of the given directory
//            if (!is_dir($fullPath)) {
//                continue;
//            }
//
//            $content = $this->scanDirRecursively($fullPath);
//            /** @var string $entry - Fullpath to each element in the directory and its subdirectories */
//            foreach ($content as $entry) {
//                if(!is_writable($entry)){
//                    $errors[] = Locale::getInstance()->get("test.message.error.not.writeable.file", array(
//                        "FILE" => str_replace($this->cmsDir,"",$entry)
//                    ));
//                }
//            }
        }


        // Compile result

        if (!empty($errors)) {
            $errorString = implode("<br />", $errors);

            return new TestResult(TestResult::STATUS_FAILED, $errorString);
        }

        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
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
        $result = array();

        $directory = rtrim($directory, "/");

        if (!is_readable($directory)) {
            return array();
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
