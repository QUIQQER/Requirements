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
     * Return all available Tests
     *
     * @return array
     */
    public static function getTests()
    {
        return [];
    }
}
