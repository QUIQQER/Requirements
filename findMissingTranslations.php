<?php

require_once dirname(__FILE__) . "/vendor/autoload.php";

$result = array();

$locales = parse_ini_file(dirname(__FILE__) . "/locales.ini.php", true);


$result = scanDirForMissingVariables(dirname(__FILE__) . "/src");

$identifiers = scanidentifiers();
$result      = array_merge($result, $identifiers);


echo "=========== DE =============" . PHP_EOL;
if (isset($result['de'])) {
    foreach ($result['de'] as $variable) {
        echo $variable . "=\"\"" . PHP_EOL;
    }
}

echo "=========== EN =============" . PHP_EOL;
if (isset($result['en'])) {
    foreach ($result['en'] as $variable) {
        echo $variable . "=\"\"" . PHP_EOL;
    }
}

function scanidentifiers()
{
    global $locales;

    $Requirements = new \QUI\Requirements\Requirements();
    $Tests        = extractTests($Requirements->getAllTests());


    $result = array();

    /** @var \QUI\Requirements\Tests\Test $Test */
    foreach ($Tests as $Test) {
        $identifier = $Test->getIdentifier();

        $localeName = "requirements.tests." . $identifier . ".name";
        $localeDesc = "requirements.tests." . $identifier . ".desc";
        if (!isset($locales['de'][$localeName])) {
            $result['de'][] = $localeName;
        }

        if (!isset($locales['de'][$localeDesc])) {
            $result['de'][] = $localeDesc;
        }

        if (!isset($locales['en'][$localeName])) {
            $result['en'][] = $localeName;
        }

        if (!isset($locales['en'][$localeDesc])) {
            $result['en'][] = $localeDesc;
        }
    }

    return $result;
}


function scanDirForMissingVariables($directory)
{
    global $locales;

    $result = array();

    foreach (scandir($directory) as $entry) {

        if ($entry == "." || $entry == "..") {
            continue;
        }

        $fullPath = $directory . "/" . $entry;
        #echo "Checking " . $fullPath . PHP_EOL;

        if (is_dir($fullPath)) {
            $tmp    = scanDirForMissingVariables($fullPath);
            $result = array_merge($result, $tmp);
            continue;
        }


        $content = file_get_contents($fullPath);
        $matches = array();
        preg_match_all("~Locale\:\:getInstance\(\)->get\(\"([a-zA-Z0-9._-]+)\"\)~", $content, $matches);

        foreach ($matches[1] as $localeVariable) {
            echo "Found: '" . $localeVariable . "'" . PHP_EOL;

            echo "\t\t --> DE:";
            if (!isset($locales['de'][$localeVariable])) {
                echo " \e[91m Missing! \e[0m" . PHP_EOL;
                $result['de'][] = $localeVariable;
            } else {
                echo "\e[92m OK! \e[0m" . PHP_EOL;
            }

            echo "\t\t --> EN:";
            if (!isset($locales['en'][$localeVariable])) {
                echo " \e[91m Missing! \e[0m" . PHP_EOL;
                $result['en'][] = $localeVariable;
            } else {
                echo "\e[92m OK! \e[0m" . PHP_EOL;
            }
        }

    }

    return $result;
}


function getGroupidentifier($classname)
{
    $ReflectionObject = new \ReflectionObject($this);

    $namespace = $ReflectionObject->getNamespaceName();

    $namespace = str_replace("QUI\\Requirements\\Tests\\", "", $namespace);
    $namespace = strtolower($namespace);
    $namespace = str_replace("\\", ".", $namespace);


    return "requirements.tests.groups." . $namespace;
}

function extractTests($Tests)
{
    $result = array();

    foreach ($Tests as $test) {
        if ($test instanceof \QUI\Requirements\Tests\Test) {
            $result[] = $test;
        }

        if (is_array($test)) {
            $result = array_merge($result, extractTests($test));
        }
    }


    return $result;
}