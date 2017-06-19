<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . "/vendor/autoload.php";

$result = \QUI\Requirements\Requirements::runAll();

print_r($result);
