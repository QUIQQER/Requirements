<?php

require_once dirname(dirname(__FILE__)) . "/vendor/autoload.php";

define('CMS_DIR',dirname(dirname(__FILE__)));



$Requirements = new \QUI\Requirements\Requirements("de");
#$Requirements = new \QUI\Requirements\Requirements();

$AllTests = $Requirements->getAllTests();

?>

<html>
<table>
    <tr>
        <td style="width: 200px;"><b>Test</b></td>
        <td style="width: 100px;"><b>Status</b></td>
        <td><b>Nachricht</b></td>
    </tr>

    <?php
    /** @var \QUI\Requirements\Tests\Test $Test */
    foreach ($AllTests as $category => $Tests) {
        echo "<tr><th colspan='3'><b>" . $category . "</b></th></tr>";
        foreach ($Tests as $Test) {
            echo "<tr>";
            echo "<td>" . $Test->getName() . "</td>";

            $Result = $Test->getResult();

            switch ($Result->getStatus()) {
                case \QUI\Requirements\TestResult::STATUS_OPTIONAL:
                case \QUI\Requirements\TestResult::STATUS_OK:
                    echo "<td style='color: green'>" . $Result->getStatusHumanReadable() . "</td>";
                    break;
                case \QUI\Requirements\TestResult::STATUS_FAILED:
                    echo "<td style='color: red'>" . $Result->getStatusHumanReadable() . "</td>";
                    break;

                case \QUI\Requirements\TestResult::STATUS_UNKNOWN:
                case \QUI\Requirements\TestResult::STATUS_WARNING:
                    echo "<td style='color: orange'>" . $Result->getStatusHumanReadable() . "</td>";
                    break;
            }
            echo "<td>" . $Result->getMessage() . "</td>";
            echo "</tr>";
        }
    }
    ?>

</table>
</html>


