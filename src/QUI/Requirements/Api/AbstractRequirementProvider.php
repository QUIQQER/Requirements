<?php

/**
 * This file contains QUI\Requirements\Api\AbstractRequirementProvider
 */

namespace QUI\Requirements\Api;

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
}
