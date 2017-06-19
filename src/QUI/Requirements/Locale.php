<?php

namespace QUI\Requirements;

use QUI\Exception;
use QUI\Utils\Singleton;

/**
 * Class Locale
 *
 * @package QUI\Requirements
 */
class Locale extends Singleton
{
    protected $langCode;
    protected $locales = array();


    /**
     * Gets the language variable for the current language
     *
     * @param $variable
     *
     * @return string - The translated value
     * @throws Exception
     */
    public function get($variable)
    {
        $variable = trim($variable);

        if (!isset($this->locales[$this->langCode][$variable])) {
            throw new Exception("Variable '" . $variable . "' not found in current language '" . $this->langCode . "'!");
        }

        return $this->locales[$this->langCode][$variable];
    }

    /**
     * Sets the cureent language code
     *
     * @param $langCode
     *
     * @throws Exception
     */
    public function setlanguage($langCode)
    {
        $this->loadLocales();
        if (!in_array($langCode, $this->getAvailableLanguages())) {
            throw new Exception("Language code is not available");
        }

        $this->langCode = $langCode;
    }

    /**
     * Returns the current language code
     *
     * @return string
     */
    public function getCurrentLangugage()
    {
        return $this->langCode;
    }

    /**
     * Returns the available language codes
     *
     * @return array
     */
    public function getAvailableLanguages()
    {
        return array_keys($this->locales);
    }

    /**
     * Loads the locales and returns the locales
     *
     * @return array
     * @throws Exception
     */
    protected function loadLocales()
    {
        $iniFile = dirname(dirname(dirname(dirname(__FILE__)))) . "/locales.ini.php";

        if (!file_exists($iniFile)) {
            throw new Exception("LanguageFile was not found: " . $iniFile);
        }

        $locales = parse_ini_file($iniFile, true);

        if (empty($locales)) {
            throw new Exception("No locales could be parsed!");
        }

        $this->locales = $locales;

        return $locales;
    }
}
