<?php

namespace QUI\Requirements;

use QUI\Requirements\Api\Coordinator;
use QUI\Requirements\Tests\Quiqqer\Checksums;
use QUI\Requirements\Tests\Test;

class Requirements
{

    /***
     * Requirements constructor.
     *
     * @param string $langCode
     *
     * @throws \Exception
     */
    public function __construct($langCode = "en")
    {
        Locale::getInstance()->setlanguage($langCode);
    }

    /**
     * Returns all available tests
     * It is recommended to use @return array
     *
     * @see Requirements::getTests()
     *
     */
    public function getAllTests()
    {
        $requirementTests    = $this->getTestsFromDirectory(dirname(__FILE__).'/Tests');
        $externalModuleTests = $this->getExternalModuleTests();
        
        return array_merge($requirementTests, $externalModuleTests);
    }

    /**
     *
     * @param array $ignore
     *
     * @return array
     */
    public function getTests(array $ignore = [])
    {
        $result             = [];
        $checksumsGroupName = "";
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

                if ($Test->getIdentifier() == "quiqqer.checksums") {
                    $checksumsGroupName = $Test->getGroupName();
                }

                $result[$groupName][] = $Test;
            }
        }

        // Put the group of the checksums test at the end of the array
        if (!empty($checksumsGroupName) && isset($result[$checksumsGroupName])) {
            $checksumsGroup = $result[$checksumsGroupName];
            unset($result[$checksumsGroupName]);
            $result[$checksumsGroupName] = $checksumsGroup;
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
        $tests = [];
        foreach (scandir($directory) as $entry) {
            if ($entry == "." || $entry == "..") {
                continue;
            }

            $fullpath = $directory."/".$entry;

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

    /**
     * Returns a list of instantiated Test Objects by querying other installed modules ServiceProviders
     *
     * @return array
     * @see Test
     *
     */
    protected function getExternalModuleTests()
    {
        $externalModuleTests = [];

        $provider = Coordinator::getInstance()->getRequirementsProvider();

        foreach ($provider as $Provider) {
            $moduleTests = $Provider->getTests();
            /** @var Test $moduleTest */
            foreach ($moduleTests as $moduleTest) {
                $externalModuleTests[$moduleTest->getGroupName()][] = $moduleTest;
            }
        }

        return $externalModuleTests;
    }
}
