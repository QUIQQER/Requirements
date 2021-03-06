<?php

namespace QUI\Requirements\Tests;

use QUI\Cache\Manager;
use QUI\Exception;
use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;

abstract class Test
{

    /** @var  String - Test Identifier */
    protected $identifier;
    /** @var  TestResult TestResult */
    protected $Result;
    /** @var bool Did the test run already */
    protected $didRun = false;

    public function __construct()
    {
        if (!isset($this->identifier) || empty($this->identifier)) {
            throw new \Exception("Every tesst needs an identifier");
        }
    }

    /**
     * Gets the tests name
     *
     * @return string
     */
    public function getName()
    {
        try {
            return Locale::getInstance()->get("requirements.tests." . $this->identifier . ".name");
        } catch (\Exception $Exception) {
            return (new \ReflectionObject($this))->getShortName();
        }
    }

    /**
     * Gets the tests description
     *
     * @return string
     */
    public function getDescription()
    {
        try {
            return Locale::getInstance()->get("requirements.tests." . $this->identifier . ".desc");
        } catch (\Exception $Exception) {
            return "";
        }
    }

    /**
     * Gets the tests description without html and php tags
     *
     * @return string
     */
    public function getDescrptionRaw()
    {
        try {
            $description = Locale::getInstance()->get("requirements.tests." . $this->identifier . ".desc");

            $description = strip_tags($description);

            return $description;
        } catch (\Exception $Exception) {
            return "";
        }
    }

    /**
     * Gets the tests group name
     *
     * @return string
     */
    public function getGroupName()
    {
        $ReflectionObject = new \ReflectionObject($this);

        $namespace = $ReflectionObject->getNamespaceName();

        $namespace = str_replace("QUI\\Requirements\\Tests\\", "", $namespace);
        $namespace = strtolower($namespace);
        $namespace = str_replace("\\", ".", $namespace);

        try {
            return Locale::getInstance()->get("requirements.tests.groups." . $namespace);
        } catch (\Exception $Exception) {
            return ucfirst($namespace);
        }
    }

    /**
     * Returns the groups identifier.
     * The identifier is generated by the directory structure below src/QUI/REquirements/Tests.
     * The slahes get replaced by dots
     *
     * @return mixed
     */
    public function getGroupIdentifier()
    {
        $ReflectionObject = new \ReflectionObject($this);

        $namespace = $ReflectionObject->getNamespaceName();

        $namespace       = str_replace("QUI\\Requirements\\Tests\\", "", $namespace);
        $namespace       = strtolower($namespace);
        $groupIdentifier = str_replace("\\", ".", $namespace);

        return $groupIdentifier;
    }

    /**
     * @return TestResult
     */
    public function getResult()
    {
        if (!$this->didRun) {
            $this->Result = $this->run();

            if (class_exists('QUI\Cache\Manager')) {
                Manager::set('quiqqer.test.result.' . $this->getIdentifier(), $this->Result);
            }

            $this->didRun = true;
        }

        return $this->Result;
    }

    /**
     * Returns the last test result from the cache.
     * If the result isn't in the cache an empty TestResult with status UNKNOWN is returned.
     *
     * @return TestResult
     */
    public function getResultFromCache()
    {
        try {
            return Manager::get('quiqqer.test.result.' . $this->getIdentifier());
        } catch (Exception $Exception) {
            return new TestResult(TestResult::STATUS_UNKNOWN);
        }
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Executes the test and returns the result
     *
     * @return TestResult
     */
    abstract protected function run();
}
