<?php

/**
 * This file contains QUI\Requirements\Api\Coordinator
 */

namespace QUI\Requirements\Api;

use QUI;

/**
 * Class Coordinator
 * - API point to get test provider
 *
 * @package QUI\ERP\Api
 */
class Coordinator extends QUI\Utils\Singleton
{
    /**
     * Return the ERP Api Provider from other packages
     *
     * @return array
     */
    public function getRequirementsProvider()
    {
        if (!\class_exists('QUI\Cache\Manager')) {
            return [];
        }
        
        $cache    = 'requirements/provider/collection';
        $provider = [];

        try {
            $collect = QUI\Cache\Manager::get($cache);
        } catch (QUI\Cache\Exception $Exception) {
            $packages = QUI::getPackageManager()->getInstalled();
            $collect  = [];

            foreach ($packages as $package) {
                try {
                    $Package = QUI::getPackage($package['name']);

                    if (!$Package->isQuiqqerPackage()) {
                        continue;
                    }

                    $collect = array_merge($collect, $Package->getProvider('requirements'));
                } catch (QUI\Exception $exception) {
                }
            }

            try {
                QUI\Cache\Manager::set($cache, $collect);
            } catch (\Exception $Exception) {
                QUI\System\Log::writeDebugException($Exception);
            }
        }

        // filter provider
        $collect = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($collect)
        );

        foreach ($collect as $entry) {
            if (!class_exists($entry)) {
                continue;
            }

            $Provider = new $entry();

            if ($Provider instanceof AbstractRequirementProvider) {
                $provider[] = $Provider;
            }
        }

        return $provider;
    }
}
