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


    public function run()
    {
        $checks = array(
            "var/tmp",
            "var/cache",
            "var",
            "etc/",
            "media/",
            "packages/",
        );

        $result = array();


        foreach ($checks as $check) {
            $fullpath = $this->cmsDir . "/" . $check;
            
            $exists = is_dir($fullpath) || file_exists($fullpath);
            // File exists, check if it is writeable
            if($exists && !is_writable($fullpath)){
               
                $result[$check] = false;
                continue;
            }
            
            // Directory or file does not exists yet, try to create it
            if(!$exists && @mkdir($fullpath,0755,true) === false){
                $result[$check] = false;
                continue;
            }
            
            // Clean up after creating the directory
            if(!$exists && is_dir($fullpath)){
                rmdir($fullpath);
            }

            $result[$check] = true;
        }
        
        
        // Build the test result
        $resultState = TestResult::STATUS_OK;
        $message = "";
        foreach($checks as $check){
            
            $writeable = $result[$check];
            
            if($writeable){
                $message .= "<span class='fa fa-check'></span>&nbsp;".$check."<br />";
                continue;
            }

            //Error
            $message .= "<span class='fa fa-times'></span>&nbsp;".$check."<br />";
            $resultState = TestResult::STATUS_FAILED;
        }
        
        return new TestResult($resultState,$message);
    }

//    public function run()
//    {
//
//        // ==================================== //
//        // Check folder permissions folders
//        // ==================================== //
//        $checks = array(//"var/cache/" => "0755",
//        );
//
//        $errors = array();
//
//        // Check required permissions
//        foreach ($checks as $file => $requiredPermission) {
//            $fullPath = $this->cmsDir . "/" . $file;
//
//            if (!file_exists($fullPath)) {
//                continue;
//            }
//
//            $perm = substr(decoct(fileperms($fullPath)), -4);
//
//            if ($perm != $requiredPermission) {
//                $errors[] = Locale::getInstance()->get("test.message.error.permission.file", array(
//                    "FILE"     => $file,
//                    "CURRENT"  => $perm,
//                    "REQUIRED" => $requiredPermission
//                ));
//            }
//        }
//
//        // ==================================== //
//        // Check writeable folders
//        // ==================================== //
//        $requiredWritable = array(
//            "", // Root diectory
//            "var/",
//            "packages/",
//            "media/",
//            "etc/"
//        );
//
//        /** @var string $file - Relative path within the CMS Directory */
//        foreach ($requiredWritable as $file) {
//
//            /** @var string $fullPath - Fullpath to the given directory/file */
//            $fullPath = $this->cmsDir . "/" . $file;
//
//            if (!file_exists($fullPath) && !is_dir($fullPath)) {
//                continue;
//            }
//
//            if (!is_writable($fullPath)) {
//                $errors[] = Locale::getInstance()->get("test.message.error.not.writeable.file", array(
//                    "FILE" => $file
//                ));
//            }
//
//
////            // Scan the files and the subdirectories  of the given directory
////            if (!is_dir($fullPath)) {
////                continue;
////            }
////
////            $content = $this->scanDirRecursively($fullPath);
////            /** @var string $entry - Fullpath to each element in the directory and its subdirectories */
////            foreach ($content as $entry) {
////                if(!is_writable($entry)){
////                    $errors[] = Locale::getInstance()->get("test.message.error.not.writeable.file", array(
////                        "FILE" => str_replace($this->cmsDir,"",$entry)
////                    ));
////                }
////            }
//        }
//
//
//        // Compile result
//
//        if (!empty($errors)) {
//            $errorString = implode("<br />", $errors);
//
//            return new TestResult(TestResult::STATUS_FAILED, $errorString);
//        }
//
//        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
//    }

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
