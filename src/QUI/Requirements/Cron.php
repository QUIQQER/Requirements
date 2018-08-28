<?php

namespace QUI\Requirements;

use QUI\Requirements\Tests\Quiqqer\Checksums;

/**
 * Class Cron
 *
 * @package QUI\Requirements
 */
class Cron
{
    /**
     * @param $params
     * @param $CronManager
     *
     * @throws \Exception
     */
    public static function executeChecksumTest($params, $CronManager)
    {

        // Notify the admins about a misconfigured cron
        if (!isset($params['email'])) {
            $AdminUsers = \QUI::getUsers()->getUsers([
                "where" => [
                    "su" => 1
                ]
            ]);

            foreach ($AdminUsers as $AdminUser) {
                \QUI::getMessagesHandler()->sendAttention(
                    $AdminUser,
                    \QUI::getLocale()->get("quiqqer/requirements", "cron.test.checksums.error.email.missing")
                );
            }

            return;
        }

        $email = $params['email'];
        if (!isset($params['sendOnWarning'])) {
            $params['sendOnWarning'] = false;
        }
        $sendOnWarning = $params['sendOnWarning'];

        $Test = new Checksums();
        $TestResult = $Test->getResult();

        if ($TestResult->getStatus() == TestResult::STATUS_OK) {
            return;
        }

        if (!$sendOnWarning && $TestResult->getStatus() == TestResult::STATUS_WARNING) {
            return;
        }

        // Send mail
        $subject = \QUI::getLocale()->get(
            "quiqqer/requirements",
            "cron.test.checksums.mail.subject"
        ) . " - " . \QUI::conf("globals", "host");

        // Hide valid files & packages
        $body = "<style>
                    .package-ok {display:none}
                    .tr-ok{display: none}
        </style>";

        // Hide warnings if only errors are relevant
        if (!$sendOnWarning) {
            $body = $body . "<style>
                    .package-warning {display:none}
                    .tr-warning{display: none}
            </style>";
        }
        
        $body = $body . Locale::getInstance()->get("checksums.cron.email.intro") ."<br />";
        $body = $body . $TestResult->getMessage();

        \QUI::getMailManager()->send($email, $subject, $body);
    }
}
