<?php

namespace QUI\Requirements\Tests\Quiqqer;

use function DusanKasan\Knapsack\contains;
use QUI\Cache\Manager;
use QUI\Composer\Composer;
use QUI\Exception;
use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;
use QUI\System\Log;
use QUI\Utils\Request\Url;
use QUI\Utils\System\File;

/**
 * Class Checksums
 *
 * @package QUI\Requirements\Tests\Quiqqer
 */
class Checksums extends Test
{

    /**
     * @var string
     */
    protected $identifier = "quiqqer.checksums";

    /**
     * @const string
     */
    const MOD_CHANGED = "modified";
    /**
     * @const string
     */
    const MOD_ADDED = "added";

    /**
     * @const int
     */
    const STATE_OK = 0;
    /**
     * @const int
     */
    const STATE_ADDED = 1;
    /**
     * @const int
     */
    const STATE_MODIFIED = 2;
    /**
     * @const int
     */
    const STATE_REMOVED = 3;
    /**
     * @const int
     */
    const STATE_UNKNOWN = 4;

    
    /**
     * Contains the packagelist of the private packages
     * @var array
     */
    protected $privatePackages = array();
    /**
     * @var null|array
     */
    protected $privateRepository = null;
    /**
     * @var array
     */
    protected $publicPackages = array();
    
    /**
     * Hols the checksums for future reference
     * @var array
     */
    protected $checksums = array();

    /**
     * @var array
     */
    protected $ignoredFiles = array(
        "checklist.md5"
    );

    /**
     * @return TestResult
     * @throws Exception
     * @throws \Exception
     */
    protected function run()
    {
        // Load the packages
        $this->publicPackages = $this->loadAvailablePublicPackages();
        try {
            $this->privatePackages = $this->loadAvailablePublicPackages();
        } catch (\Exception $Exception) {
            $this->privatePackages = array();
        }

        $packages = \QUI::getPackageManager()->getInstalled();
        $result = array();
        foreach ($packages as $packageData) {
            try {
                $packageName = $packageData['name'];
                $result[$packageName] = $this->checkPackage($packageName);
            } catch (\Exception $Exception) {
                continue;
            }
        }

        $htmlOutput = $this->buildHTMLOutput($result);
        $consoleOutput = $this->buildConsoleOutput($result);

        if ($this->hasErrors($result)) {
            return new TestResult(TestResult::STATUS_FAILED, $htmlOutput, $consoleOutput);
        }

        if ($this->hasWarnings($result)) {
            return new TestResult(TestResult::STATUS_WARNING, $htmlOutput, $consoleOutput);
        }

        return new TestResult(TestResult::STATUS_OK);
    }

    /**
     * Builds the HTMl Output
     *
     * @param $result
     *
     * @return string
     * @throws \Exception
     */
    protected function buildHTMLOutput($result)
    {
        $output = "";
        $cacheFile = VAR_DIR . "/tmp/requirements_checks_result_package";
        $cache = array();

        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        // SORT_FLAG_CASE | SORT_STRING  ==> Sort as case INSENSITIVE string
        ksort($result, SORT_FLAG_CASE | SORT_STRING);

        $unknownPackages = array();

        foreach ($result as $package => $files) {
            ksort($files, SORT_FLAG_CASE | SORT_STRING);

            $packageClass = "package-ok";
            $packageState = self::STATE_OK;

            $rowsString = "";
            // Sort the files - Errors > Warnings > OK
            uasort($files, function ($a, $b) {
                $aState = $this->getRowState($a);
                $bState = $this->getRowState($b);
                
                if ($aState == $bState) {
                    return 0;
                }
                
                if (in_array($aState, array(self::STATE_ADDED,self::STATE_MODIFIED,self::STATE_REMOVED))) {
                    return -1;
                }
                
                if ($bState == self::STATE_OK) {
                    return -1;
                }
                
                return 1;
            });

            // Build the outputs of the files for each package
            foreach ($files as $file => $states) {
                if (in_array($file, $this->ignoredFiles)) {
                    continue;
                }

                if (!isset($states['local']) && isset($states['remote'])) {
                    $states['local'] = self::STATE_REMOVED;
                }

                if (!isset($states['remote'])) {
                    $states['remote'] = self::STATE_UNKNOWN;
                }

                $rowState = $this->getRowState($states);
                // Check if file has warnings
                $rowWarning = ($states['local'] == self::STATE_UNKNOWN || $states['remote'] == self::STATE_UNKNOWN);
                // Check if file is corrupted
                $rowError = ($states['local'] == self::STATE_ADDED ||
                    $states['local'] == self::STATE_MODIFIED ||
                    $states['local'] == self::STATE_REMOVED ||
                    $states['remote'] == self::STATE_ADDED ||
                    $states['remote'] == self::STATE_MODIFIED ||
                    $states['remote'] == self::STATE_REMOVED
                );

                $rowClass = "tr-ok";
                if (!$rowError && $rowWarning && $packageClass !== "package-error") {
                    $rowClass = "tr-warning";
                    $packageClass = "package-warning";
                    $packageState = self::STATE_UNKNOWN;
                }
                if ($rowError) {
                    $rowClass = "tr-error";
                    $packageClass = "package-error";
                }

                try {
                    $checksumFile = isset($this->checksums[$package][$file]['file']) ? $this->checksums[$package][$file]['file'] : "--";
                    $checksumLocal = isset($this->checksums[$package][$file]['local']) ? $this->checksums[$package][$file]['local'] : "--";
                    $checksumRemote = isset($this->checksums[$package][$file]['remote']) ? $this->checksums[$package][$file]['remote'] : "--";

                    $row = "<tr class='" . $rowClass . "' title='" . $this->getRowStateDescription($rowState) . "'>";
                    $row .= "<td>" . $file . "</td>";

                    $row .= "<td title='" . $checksumFile . "'>" .
                        substr($checksumFile, 0, 4) .
                        "</td>";

                    $row .= "<td title='" . $checksumLocal . "' class='td-state-" . $states['local'] . "'>" .
                        $this->getStateHumanReadable($states['local']) .
                        " (" . substr($checksumLocal, 0, 4) . ")" .
                        "</td>";

                    $row .= "<td title='" . $checksumRemote . "' class='td-state-" . $states['remote'] . "'>" .
                        $this->getStateHumanReadable($states['remote']) .
                        " (" . substr($checksumRemote, 0, 4) . ")" .
                        "</td>";

                    $row .= "</tr>";
                    $rowsString .= $row;
                } catch (\Exception $Exception) {
                    continue;
                }
            }

            // Ignore the package if all files are valid
            if ($packageClass == "package-ok") {
                continue;
            }

            // Build the table containing all the files of the package
            $table = "<table>";
            $table .= "<thead>";
            $table .= "    <tr>";
            $table .= "        <th>" . Locale::getInstance()->get("checksums.table.header.file") . "</th>";
            $table .= "        <th>" . Locale::getInstance()->get("checksums.table.header.checksum.file") . "</th>";
            $table .= "        <th>" . Locale::getInstance()->get("checksums.table.header.checksum.local") . "</th>";
            $table .= "        <th>" . Locale::getInstance()->get("checksums.table.header.checksum.remote") . "</th>";
            $table .= "    </tr>";
            $table .= "</thead>";
            $table .= "<tbody>";
            $table .= $rowsString;
            $table .= "</tbody>";
            $table .= "</table>";

            $cache[$package] = $table;

            if ($packageState == self::STATE_UNKNOWN) {
                $unknownPackages[] = $package;
                continue;
            }

            // Build output for package
            $output .= "<div class='" . $packageClass . "' data-package='" . $package . "'>";
            $output .= "<span>" . $package . "</span>";
            $output .= "</div>";
        }

        $output .= "<span class='unknown-packages-warning' title='" . implode(PHP_EOL, $unknownPackages) . "'>";
        $output .= Locale::getInstance()->get("checksums.unknown.packages");
        $output .= "</span>";

        // "cache" file
        file_put_contents($cacheFile, json_encode($cache));

        return $output;
    }

    /**
     * Builds the output which can be displayed on the console
     *
     * @param $result
     *
     * @return string
     */
    protected function buildConsoleOutput($result)
    {
        $output = "";
        foreach ($result as $package => $files) {
            $output .= "========== " . str_pad($package, 30, " ", STR_PAD_BOTH) . " ==========" . PHP_EOL;
            foreach ($files as $file => $states) {
                try {
                    $output .= "\t" . str_pad($file, 100, " ", STR_PAD_RIGHT);
                    $output .= "\t" . str_pad($this->getStateHumanReadable($states['local']), 15, " ", STR_PAD_LEFT);
                    $output .= "\t" . str_pad($this->getStateHumanReadable($states['remote']), 15, " ", STR_PAD_LEFT);
                    $output .= PHP_EOL;
                } catch (\Exception $Exception) {
                    continue;
                }
            }
        }

        return $output;
    }

    /**
     * Checks the given package
     *
     * @param $package
     *
     * @return array
     */
    protected function checkPackage($package)
    {

        $result = array();
        $packageDir = OPT_DIR . $package;
        $packageContent = $this->getDirContents($packageDir);

        /* ******************************** */
        /* **********  Local  ************ */
        /* ******************************** */
        try {
            $localResult = $this->checkLocalPackageMD5($package);
            foreach ($localResult as $file => $state) {
                $result[$file]['local'] = $state;
            }
        } catch (\Exception $Exception) {
            foreach ($packageContent as $file) {
                $result[$file]['local'] = self::STATE_UNKNOWN;
            }
        }

        /* ******************************************************************* */
        /* **********  Remote - Check if remote can be validated  ************ */
        /* ******************************************************************* */

        // Check the remote package md5
        if (!file_exists($packageDir . "/composer.json")) {
            foreach ($packageContent as $file) {
                $result[$file]['remote'] = self::STATE_UNKNOWN;
            }

            return $result;
        }

        // Check if this module is a QUIQQER package
        $packageData = json_decode(file_get_contents($packageDir . "/composer.json"), true);
        if (!isset($packageData['type']) || strpos(strtolower($packageData['type']), "quiqqer") === false) {
            foreach ($packageContent as $file) {
                $result[$file]['remote'] = self::STATE_UNKNOWN;
            }

            return $result;
        }

        // Lock for a version attribute to see which package we are compairing against
        if (!isset($packageData['version'])) {
            foreach ($packageContent as $file) {
                $result[$file]['remote'] = self::STATE_UNKNOWN;
            }

            return $result;
        }

        /* ******************************** */
        /* **********  Remote  ************ */
        /* ******************************** */

        try {
            $remoteResult = $this->checkRemotePackageMD5($package, $packageData['version']);
            foreach ($remoteResult as $file => $state) {
                $result[$file]['remote'] = $state;
            }
        } catch (\Exception $Exception) {
            foreach ($packageContent as $file) {
                $result[$file]['remote'] = self::STATE_UNKNOWN;
            }

            return $result;
        }

        return $result;
    }

    /**
     * Checks the packages content.
     * Returns an array wirh all files and their states.
     * States:
     *
     * @see Checksums::STATE_OK
     * @see Checksums::STATE_ADDED
     * @see Checksums::STATE_MODIFIED
     * @see Checksums::STATE_REMOVED
     *
     * @see Checksum::MOD_CHANGED
     *
     * @param $package
     * @param $version
     *
     * @return array| true
     * @throws Exception
     */
    protected function checkRemotePackageMD5($package, $version)
    {
        try {
            $validChecksums = $this->getCorrectRemoteChecksums($package, $version);
        } catch (Exception $Exception) {
            throw $Exception;
        }

        $packageDir = OPT_DIR . $package;
        $packageContent = $this->getDirContents($packageDir);

        $fileStates = array();
        foreach ($packageContent as $file) {
            if (in_array($file, $this->ignoredFiles)) {
                $fileStates[$file] = self::STATE_OK;
                continue;
            }

            $currentChecksum = md5_file($packageDir . "/" . $file);
            $this->checksums[$package][$file]['file'] = $currentChecksum;
            if (!isset($validChecksums[$file])) {
                $fileStates[$file] = self::STATE_ADDED;
                continue;
            }
            $validChecksum = $validChecksums[$file];
            
            $this->checksums[$package][$file]['remote'] = $validChecksum;

            $fileValid = ($validChecksum == $currentChecksum);

            if (!$fileValid) {
                $fileStates[$file] = self::STATE_MODIFIED;
                continue;
            }

            $fileStates[$file] = self::STATE_OK;
        }

        foreach ($validChecksums as $file => $checksum) {
            if (!in_array($file, $packageContent)) {
                $fileStates[$file] = self::STATE_REMOVED;
            }
        }

        return $fileStates;
    }

    /**
     * Checks the packages local checksum file
     *
     * @param $package
     *
     * @return array
     * @throws Exception
     */
    protected function checkLocalPackageMD5($package)
    {

        try {
            $validChecksums = $this->getCorrectLocalChecksums($package);
        } catch (\Exception $Exception) {
            throw new Exception("Could not read the packages local checksums.");
        }

        $packageDir = OPT_DIR . $package;
        $packageContent = $this->getDirContents($packageDir);

        $fileStates = array();
        foreach ($packageContent as $file) {
            if (in_array($file, $this->ignoredFiles)) {
                $fileStates[$file] = self::STATE_OK;
                continue;
            }

            $currentChecksum = md5_file($packageDir . "/" . $file);
            $this->checksums[$package][$file]['file'] = $currentChecksum;
            
            if (!isset($validChecksums[$file])) {
                $fileStates[$file] = self::STATE_ADDED;
                continue;
            }

            $validChecksum = $validChecksums[$file];

            
            $this->checksums[$package][$file]['local'] = $validChecksum;

            $fileValid = ($validChecksum == $currentChecksum);
            if (!$fileValid) {
                $fileStates[$file] = self::STATE_MODIFIED;
                continue;
            }

            $fileStates[$file] = self::STATE_OK;
        }

        foreach ($validChecksums as $file => $checksum) {
            if (!in_array($file, $packageContent)) {
                $fileStates[$file] = self::STATE_REMOVED;
            }
        }

        return $fileStates;
    }

    /**
     * Gets all files within the package
     *
     * @param $directory
     *
     * @return array
     */
    protected function getDirContents($directory)
    {
        $packageContent = array();

        $DirectoryIterator = new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS);
        $Iterator = new \RecursiveIteratorIterator($DirectoryIterator);

        foreach ($Iterator as $key => $value) {
            $packageContent[] = str_replace($directory . "/", "", $value);
        }

        return $packageContent;
    }

    /* ***************************** */
    /* ********* Checksums ********* */
    /* ***************************** */
    /**
     * Gets the md5 Checksums for the files contained in the package
     *
     * @param $package
     * @param $version
     *
     * @return mixed
     * @throws Exception
     */
    protected function getCorrectRemoteChecksums($package, $version)
    {
        $vendor = explode("/", $package, 2)[0];
        $packageName = explode("/", $package, 2)[1];
        ;

        $isPrivate = !in_array($package, $this->publicPackages);

        // Build the checksum url for private and public packages respectively
        if ($isPrivate) {
            $privaterepository = $this->getPrivatePackagesRepo();
            if (!isset($privaterepository[$package][$version]['dist']['url'])) {
                throw new Exception("Could not retrieve a checksum from the updateserver", 404);
            }

            $downloadURL = $privaterepository[$package][$version]['dist']['url'];
            $url = str_replace("updateserver/bin/download.php", "updateserver/bin/getChecksum.php", $downloadURL);
        } else {
            $url = "https://update.quiqqer.com/files/" . $package . "/" . $packageName . "-" . $version . ".zip.md5";
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true
        ));

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info['http_code'] !== 200) {
            throw new Exception("Could not retrieve a checksum from the updateserver", 404);
        }

        $lines = explode(PHP_EOL, $result);
        $checksums = array();

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $md5Sum = explode("  ", $line, 2)[0];
            $file = explode("  ", $line, 2)[1];

            $checksums[$file] = $md5Sum;
        }

        return $checksums;
    }

    /**
     * Gets the local checksums from the package
     *
     * @param $package
     *
     * @return array
     * @throws Exception
     */
    protected function getCorrectLocalChecksums($package)
    {
        $packageDir = OPT_DIR . $package;

        $checksumFiles = array(
            "checklist.md5",
            "checksums.md5"
        );

        $checksums = array();
        foreach ($checksumFiles as $checksumFile) {
            $path = $packageDir . "/" . $checksumFile;

            if (!file_exists($path)) {
                continue;
            }

            $content = file_get_contents($path);
            $lines = explode(PHP_EOL, $content);
            foreach ($lines as $line) {
                if (empty(trim($line))) {
                    continue;
                }

                $md5Sum = explode("  ", $line, 2)[0];
                $file = explode("  ", $line, 2)[1];

                $checksums[$file] = $md5Sum;
            }

            return $checksums;
        }

        throw new Exception("This package does not provide a checksum file");
    }


    /* ***************************** */
    /* ******* Updateserver ******** */
    /* ***************************** */
    /**
     * Loads the packages,that are avaialable on the public updateserver
     *
     * @throws Exception
     * @return array
     */
    protected function loadAvailablePublicPackages()
    {
        $url = "https://update.quiqqer.com/packages.json";

        $json = Url::get($url);
        $packages = json_decode($json, true);

        $packages = array_keys($packages['packages']);

        return $packages;
    }

    /**
     * Loads the avaialble packages from the private update server
     *
     * @return array
     * @throws Exception
     */
    protected function loadAvailablePrivatePackages()
    {
        $data = $this->getPrivatePackagesRepo();

        return array_keys($data['packages']);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getPrivatePackagesRepo()
    {
        if (!is_null($this->privateRepository) && !empty($this->privateRepository)) {
            return $this->privateRepository;
        }

        $composerJson = json_decode(file_get_contents(VAR_DIR . "/composer/composer.json"), true);
        $repositories = $composerJson['repositories'];

        $header = array();
        foreach ($repositories as $repoData) {
            if (!isset($repoData['url'])) {
                continue;
            }

            if ($repoData['url'] != "https://license.quiqqer.com/private") {
                continue;
            }

            if (!isset($repoData['options']['http']['header'])) {
                continue;
            }

            $header = $repoData['options']['http']['header'];
        }

        if (empty($header)) {
            throw new Exception("Could not retrieve private packages. No headers provided.");
        }

        $json = Url::get("https://license.quiqqer.com/private/packages.json", array(
            CURLOPT_HTTPHEADER => $header
        ));

        $data = json_decode($json, true);
        $this->privateRepository = $data;

        return $data['packages'];
    }


    /* ***************************** */
    /* ****** Localization ********* */
    /* ***************************** */
    /**
     * Returns a human readable and localized state
     *
     * @param $state
     *
     * @return string
     * @throws \Exception
     */
    protected function getStateHumanReadable($state)
    {
        switch ($state) {
            case Checksums::STATE_UNKNOWN:
                return Locale::getInstance()->get("checksums.state.unknown");
                break;
            case Checksums::STATE_OK:
                return Locale::getInstance()->get("checksums.state.ok");
                break;
            case Checksums::STATE_MODIFIED:
                return Locale::getInstance()->get("checksums.state.modified");
                break;
            case Checksums::STATE_ADDED:
                return Locale::getInstance()->get("checksums.state.added");
                break;
            case Checksums::STATE_REMOVED:
                return Locale::getInstance()->get("checksums.state.removed");
                break;
        }

        return Locale::getInstance()->get("checksums.state.unknown");
    }

    /**
     * Returns a localized description for the package state
     *
     * @param $state
     *
     * @return string
     * @throws \Exception
     */
    protected function getRowStateDescription($state)
    {
        $description = "";
        switch ($state) {
            case self::STATE_OK:
                $description = Locale::getInstance()->get("checksums.state.ok.desc");
                break;
            case self::STATE_UNKNOWN:
                $description = Locale::getInstance()->get("checksums.state.unknown.desc");
                break;
            case self::STATE_ADDED:
                $description = Locale::getInstance()->get("checksums.state.added.desc");
                break;
            case self::STATE_MODIFIED:
                $description = Locale::getInstance()->get("checksums.state.modified.desc");
                break;
            case self::STATE_REMOVED:
                $description = Locale::getInstance()->get("checksums.state.removed.desc");
                break;
        }

        return $description;
    }


    /* ********************** */
    /* ****** Helper ******** */
    /* ********************** */

    #region Helper

    /**
     * @param $result
     *
     * @return bool
     */
    protected function hasWarnings($result)
    {
        return $this->isInArrayRecursive(self::STATE_UNKNOWN, $result, true);
    }

    /**
     * @param $result
     *
     * @return bool
     */
    protected function hasErrors($result)
    {
        $hasErrors = $this->isInArrayRecursive(self::STATE_ADDED, $result, true);
        $hasErrors = $hasErrors || $this->isInArrayRecursive(self::STATE_MODIFIED, $result, true);
        $hasErrors = $hasErrors || $this->isInArrayRecursive(self::STATE_REMOVED, $result, true);

        return $hasErrors;
    }

    /**
     * Checks if the needle is in the array recursively
     *
     * @param $needle
     * @param $haystack
     * @param bool $strict
     *
     * @return bool
     */
    protected function isInArrayRecursive($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->isInArrayRecursive(
                $needle,
                $item,
                $strict
            ))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the state of the row
     *
     * @param $fileStates - Array of the file in format (['local'] => STATE,  ['remote'] => STATE)
     *
     * @return int
     */
    protected function getRowState($fileStates)
    {
        if (!isset($fileStates['local']) && isset($fileStates['remote'])) {
            $fileStates['local'] = self::STATE_REMOVED;
        }

        if (!isset($fileStates['remote'])) {
            $fileStates['remote'] = self::STATE_UNKNOWN;
        }
        
        
        if ($fileStates['local'] == self::STATE_REMOVED || $fileStates['remote'] == self::STATE_REMOVED) {
            return self::STATE_REMOVED;
        }

        if ($fileStates['local'] == self::STATE_MODIFIED || $fileStates['remote'] == self::STATE_MODIFIED) {
            return self::STATE_MODIFIED;
        }

        if ($fileStates['local'] == self::STATE_ADDED || $fileStates['remote'] == self::STATE_ADDED) {
            return self::STATE_ADDED;
        }

        if ($fileStates['local'] == self::STATE_UNKNOWN && $fileStates['remote'] == self::STATE_UNKNOWN) {
            return self::STATE_UNKNOWN;
        }
        
        return self::STATE_OK;
    }
    #endregion
}
