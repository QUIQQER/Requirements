<?php

/**
 * This file contains QUI\Requirements\Api\AbstractRequirementProvider
 */

namespace QUI\Requirements\Api;

use Exception;
use QUI;

/**
 * Class AbstractErpProvider
 *
 * @package QUI\ERP\Api
 */
abstract class AbstractRequirementProvider
{
    /**
     * List of tests
     *
     * @var array
     */
    protected $tests = [];

    /**
     * @param QUI\Requirements\Tests\Test $Test
     */
    public function addTest(QUI\Requirements\Tests\Test $Test)
    {
        $this->tests[] = $Test;
    }

    /**
     * Return all available Tests
     *
     * @return array
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Returns an array with the locales that the modules provides
     * The arrays keys are the two letter language codes like `de` or `en`.
     * Within these keys there is another array containing the locale variables as key value pairs of the variables name and its translations.
     *
     * @return array
     * @throws Exception
     */
    public function getLocales()
    {
        $iniFile = $this->getLocalesPath();

        if (!file_exists($iniFile)) {
            throw new Exception('LanguageFile was not found: '.$iniFile);
        }

        $locales = parse_ini_file($iniFile, true);
        if (empty($locales)) {
            throw new Exception('No locales could be parsed!');
        }

        return $locales;
    }

    /**
     * Returns the packages locales.ini.php file path
     *
     * @return string
     */
    protected function getLocalesPath()
    {
        return dirname(dirname(dirname(dirname(__FILE__)))).'/locales.ini.php';
    }
}
