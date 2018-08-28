<?php

namespace QUI\Requirements\Tests\PHP\Configuration;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;
use QUI\Requirements\Utils;

/**
 * Class UploadSize
 *
 * @package QUI\Requirements\Tests\PHP\Configuration
 */
class UploadSize extends Test
{
    /**
     * @var string
     */
    protected $identifier = "php.configuration.uploadsize";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        
        // Check if uploads are enabled
        $requiredValue = "on";
        $currentValue  = trim(strtolower(ini_get("file_uploads")));


        if ($currentValue != true && $currentValue != $requiredValue) {
            return new TestResult(
                TestResult::STATUS_WARNING,
                Locale::getInstance()->get("requirements.error.uploads.deactivated")
            );
        }

        // Check the upload max file size
        $requiredValue = 8;
        $currentValue  = trim(strtolower(ini_get("upload_max_filesize")));
        $currentValue = Utils::parseMegaByteFromHumanReadable($currentValue);

        if ($currentValue < $requiredValue) {
            return new TestResult(
                TestResult::STATUS_WARNING,
                Locale::getInstance()->get("requirements.error.uploadsize.low")
            );
        }


        // Check the max post size
        $requiredValue = 8;
        $currentValue  = trim(strtolower(ini_get("post_max_size")));
        $currentValue = Utils::parseMegaByteFromHumanReadable($currentValue);

        if ($currentValue < $requiredValue) {
            return new TestResult(
                TestResult::STATUS_WARNING,
                Locale::getInstance()->get("requirements.error.postsize.low")
            );
        }
     

        return new TestResult(TestResult::STATUS_OK);
    }
}
