<?php

namespace QUI\Requirements;

use QUI\Requirements\Tests\Test;

class Requirements
{

    /***
     * Requirements constructor.
     *
     * @param $langCode
     */
    public function __construct($langCode = "en")
    {
        Locale::getInstance()->setlanguage($langCode);
    }

    /**
     * Returns all available tests
     *
     * @return array
     */
    public function getAllTests()
    {
        return $this->getTestsFromDirectory(dirname(__FILE__) . "/Tests");
    }

    /**
     *
     * @param array $ignore
     * @return array
     */
    public function getTests(array $ignore)
    {
        $result = array();
        foreach ($this->getAllTests() as $groupName => $Tests) {

            /** @var Test $Test */
            foreach ($Tests as $Test) {
                if (in_array($Test->getIdentifier(), $ignore)) {
                    continue;
                }

                if (in_array($Test->getGroupIdentifier(), $ignore)) {
                    continue;
                }

                foreach ($ignore as $ignoreEntry) {
                    if (strpos($ignoreEntry, $Test->getGroupIdentifier()) !== false) {
                        continue 2;
                    }
                }

                $result[$groupName][] = $Test;
            }
        }

        return $result;
    }

    /**
     * @param $directory
     *
     * @return array
     */
    protected function getTestsFromDirectory($directory)
    {
        $tests = array();
        foreach (scandir($directory) as $entry) {
            if ($entry == "." || $entry == "..") {
                continue;
            }

            $fullpath = $directory . "/" . $entry;

            if (is_dir($fullpath)) {
                $tests = array_merge($tests, $this->getTestsFromDirectory($fullpath));
                continue;
            }

            $className = str_replace(dirname(dirname(dirname(__FILE__))), "", $fullpath);
            $className = str_replace(".php", "", $className);
            $className = str_replace("/", "\\", $className);

            if ($className == "\QUI\Requirements\Tests\Test") {
                continue;
            }

            if (!class_exists($className)) {
                continue;
            }

            try {
                $Test = new $className();
            } catch (\Exception $Exception) {
                continue;
            }

            if (!($Test instanceof Test)) {
                continue;
            }

            $tests[$Test->getGroupName()][] = $Test;
        }

        return $tests;
    }
}
