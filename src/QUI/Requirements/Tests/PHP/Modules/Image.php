<?php

namespace QUI\Requirements\Tests\PHP\Modules;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

/**
 * Class PDO
 * @package QUI\Requirements\Tests\PHP\Modules
 */
class Image extends Test
{

    /**
     * @var string
     */
    protected $identifier = "php.modules.image";

    /**
     * @return TestResult
     * @throws \Exception
     */
    protected function run()
    {
        $libraries = array();

        // ImageMagick PHP
        if (class_exists('Imagick')) {
            $libraries[] = 'PHP Image Magick';
        }

        // GD Lib
        if (function_exists('imagecopyresampled')) {
            $libraries[] = 'GD Lib';
        }


        if (empty($libraries)) {
            return new TestResult(
                TestResult::STATUS_FAILED,
                Locale::getInstance()->get('requirements.error.module.imagelibs.missing')
            );
        }

        return new TestResult(TestResult::STATUS_OK);
    }
}
