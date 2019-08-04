<?php

namespace QUI\Requirements;

use Exception;
use QUI\Requirements\Api\AbstractRequirementProvider;
use QUI\Requirements\Api\Coordinator;
use QUI\Requirements\Tests\Test;

/**
 * Class Locale
 *
 * @package QUI\Requirements
 */
class Locale
{
    protected $langCode;
    protected $locales = [];

    protected static $Instance = null;

    /**
     * Gets the language variable for the current language
     *
     * @param $variable
     *
     * @param array $params
     *
     * @return string - The translated value
     * @throws Exception
     */
    public function get($variable, $params = [])
    {
        $variable = trim($variable);

        if (!isset($this->langCode) || empty($this->langCode)) {
            $this->setlanguage("en");
        }

        if (!isset($this->locales[$this->langCode][$variable])) {
            throw new Exception("Variable '".$variable."' not found in current language '".$this->langCode."'!");
        }

        $text = $this->locales[$this->langCode][$variable];

        foreach ($params as $key => $value) {
            $text = str_replace("%".$key."%", $value, $text);
        }

        return $text;
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
        if (in_array($langCode, $this->getAvailableLanguages())) {
            $this->langCode = $langCode;

            return;
        }

        // Check for the short form of the code
        if (strpos($langCode, "_") !== false) {
            $parts = explode("_", $langCode);
            if (in_array($parts[0], $this->getAvailableLanguages())) {
                $this->langCode = $parts[0];

                return;
            }
        }

        // Check for english as default
        if (in_array("en_GB", $this->getAvailableLanguages())) {
            $this->langCode = "en_GB";

            return;
        }

        if (in_array("en", $this->getAvailableLanguages())) {
            $this->langCode = "en";

            return;
        }

        throw new Exception("Language code is not available");
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
        $iniFile = dirname(dirname(dirname(dirname(__FILE__))))."/locales.ini.php";

        if (!file_exists($iniFile)) {
            throw new Exception("LanguageFile was not found: ".$iniFile);
        }

        $locales = parse_ini_file($iniFile, true);

        if (empty($locales)) {
            throw new Exception("No locales could be parsed!");
        }

        $this->locales = $locales;

        $this->loadExternalModuleLocales();

        return $locales;
    }

    /**
     * Adds the locales provided by other modules to the existing locales property
     *
     * @throws Exception
     */
    protected function loadExternalModuleLocales()
    {
        $registeredProviders = Coordinator::getInstance()->getRequirementsProvider();
        /** @var AbstractRequirementProvider $Provider */
        foreach ($registeredProviders as $Provider) {
            $moduleLocales = $Provider->getLocales();
            foreach ($moduleLocales as $langGroup => $locales) {
                foreach ($locales as $localeVariableName => $translation) {
                    $this->locales[$langGroup][$localeVariableName] = $translation;
                }
            }
        }
    }

    /**
     * @return Locale
     */
    public static function getInstance()
    {
        if (!is_null(self::$Instance)) {
            return self::$Instance;
        }

        self::$Instance = new Locale();

        return self::$Instance;
    }
}
