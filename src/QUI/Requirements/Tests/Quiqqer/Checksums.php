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

class Checksums extends Test
{

    protected $identifier = "quiqqer.checksums";

    const MOD_CHANGED = "modified";
    const MOD_ADDED = "added";

    const STATE_OK = 0;
    const STATE_ADDED = 1;
    const STATE_MODIFIED = 2;
    const STATE_REMOVED = 3;
    const STATE_UNKNOWN = 4;

    // Load the packages.json and check which packages are available on which server
    protected $privatePackages = array();
    protected $privateRepository = null;
    protected $publicPackages = array();

    // Store the checksums in this array for future reference
    protected $checksums = array();

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

        foreach ($result as $package => $files) {
            ksort($files, SORT_FLAG_CASE | SORT_STRING);

            $packageClass = "package-ok";
            $packageState = self::STATE_OK;

            $rows = "";
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

                foreach ($states as $s) {
                    switch ($s) {
                        // Package has unknown checksums
                        case self::STATE_UNKNOWN:
                            if ($packageState == self::STATE_OK) {
                                $packageState = self::STATE_UNKNOWN;
                            }
                            break;
                        // Package has errors!
                        case self::STATE_ADDED:
                        case self::STATE_MODIFIED:
                        case self::STATE_REMOVED:
                            $packageState = $s;
                            break;
                    }
                }

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
                }
                if ($rowError) {
                    $rowClass = "tr-error";
                    $packageClass = "package-error";
                }

                try {
                    $checksumFile = isset($this->checksums[$package][$file]['file']) ? $this->checksums[$package][$file]['file'] : "--";
                    $checksumLocal = isset($this->checksums[$package][$file]['local']) ? $this->checksums[$package][$file]['local'] : "--";
                    $checksumRemote = isset($this->checksums[$package][$file]['remote']) ? $this->checksums[$package][$file]['remote'] : "--";

                    $row = "<tr class='" . $rowClass . "' title='" . $this->getPackageStateDescription($packageState) . "'>";
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
                    $rows .= $row;
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
            $table .= $rows;
            $table .= "</tbody>";
            $table .= "</table>";

            $cache[$package] = $table;

            // Build output for package
            $output .= "<div class='" . $packageClass . "' data-package='" . $package . "'>";
            $output .= "<span>" . $package . "</span>";
            $output .= "</div>";
        }

        // "cache" file
        file_put_contents($cacheFile, json_encode($cache));

        return $output;
    }

    /**
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
     * @throws Exception
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

            if (!isset($validChecksums[$file])) {
                $fileStates[$file] = self::STATE_ADDED;
                continue;
            }

            $validChecksum = $validChecksums[$file];
            $currentChecksum = md5_file($packageDir . "/" . $file);

            $this->checksums[$package][$file]['file'] = $currentChecksum;
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

            if (!isset($validChecksums[$file])) {
                $fileStates[$file] = self::STATE_ADDED;
                continue;
            }

            $validChecksum = $validChecksums[$file];
            $currentChecksum = md5_file($packageDir . "/" . $file);

            $this->checksums[$package][$file]['file'] = $currentChecksum;
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
    protected function getPackageStateDescription($state)
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

    /**
     * @param $result
     *
     * @return bool
     */
    protected function hasWarnings($result)
    {
        return $this->in_array_r(self::STATE_UNKNOWN, $result, true);
    }

    /**
     * @param $result
     *
     * @return bool
     */
    protected function hasErrors($result)
    {
        $hasErrors = $this->in_array_r(self::STATE_ADDED, $result, true);
        $hasErrors = $hasErrors || $this->in_array_r(self::STATE_MODIFIED, $result, true);
        $hasErrors = $hasErrors || $this->in_array_r(self::STATE_REMOVED, $result, true);

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
    protected function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r(
                $needle,
                $item,
                $strict
            ))) {
                return true;
            }
        }

        return false;
    }
}
