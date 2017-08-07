<?php

namespace QUI\Requirements\Tests\System;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;

class Geolocation extends Test
{
    protected $identifier = "system.geolocate";

    protected function run()
    {
        if (isset($_SERVER["GEOIP_COUNTRY_CODE"])) {
            return new TestResult(TestResult::STATUS_OK);
        }

        if (function_exists('apache_get_modules')) {

            if (in_array('mod_geoip', apache_get_modules())) {
                return new TestResult(TestResult::STATUS_OK);
            }

            return new TestResult(
                TestResult::STATUS_WARNING,
                Locale::getInstance()->get("requirements.error.webserver.headers.missing")
            );
        }

        if(extension_loaded("geoip")){
            return new TestResult(TestResult::STATUS_OK);
        }
        
        // phpinfo test
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();

        if (strpos('mod_geoip', $phpinfo) !== false) {
            return new TestResult(TestResult::STATUS_OK);
        }
        
        
        return new TestResult(
            TestResult::STATUS_WARNING,
            "requirements.error.geolocate.not.found"
        );
    }


}