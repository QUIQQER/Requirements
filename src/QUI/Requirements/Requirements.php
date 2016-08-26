<?php

namespace QUI\Requirements;

class Requirements
{

    public static function runAll()
    {

    }

    public static function runPHP()
    {

    }

    public static function testPHPVersion()
    {
        $limit = ini_get('memory_limit');
        $last  = '';

        # Error while fetching value or value not set.
        if (empty($limit)) {
            return new TestResult(
                TestResult::STATUS_UNKNOWN,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.memorylimit.undetected')
            );

        }

        switch ($last) {
            case 'g':
                $limit *= 1024;
            case 'm':
                $limit *= 1024;
            case 'k':
                $limit *= 1024;
        }

        $limit = round((int)$limit / 1048576);

        if ($limit >= 128 || $limit == -1) {
            $result = new TestResult(TestResult::STATUS_OK);
        } else {
            $result = new TestResult(
                TestResult::STATUS_FAILED,
                \QUI::getLocale()->get('quiqqer/requirements', 'requirements.error.memorylimit.insufficient')
            );
        }

        return $result;
    }

    private static function testPHPMemLimit()
    {

    }

    private static function testPHPModulePDO()
    {

    }

    private static function testPHPModuleDom()
    {

    }

    private static function testPHPModuleCurl()
    {

    }

    private static function testPHPModuleImageLibs()
    {

    }

    private static function testPHPModuleTidy()
    {

    }

}