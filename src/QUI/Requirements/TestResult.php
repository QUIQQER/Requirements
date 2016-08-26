<?php

namespace QUI\Requirements;

/**
 * Class TestResult
 * @package QUI\Requirements
 */
class TestResult
{
    /**
     * @var int $status - The Statuscode.
     */
    private $status;

    /**
     * @var string - The status message
     */
    private $message;

    /**
     * Test has failed
     */
    const STATUS_FAILED = 0;

    /**
     * Test was successfully
     */
    const STATUS_OK = 1;

    /**
     * Test could not be executed. Or result could not be reliably determined.
     */
    const STATUS_UNKNOWN = 2;

    /**
     * TestResult constructor.
     * STATUS_FAILED = 0
     * STATUS_OK = 1
     * STATUS_UNKNOWN = 2
     * @param int $status - Constants defined in QUI\Requirements\Testresult
     * @param string $message - (optional) Status message.
     */
    public function __construct($status, $message = "")
    {
        $this->status  = $status;
        $this->message = $message;
    }

    /**
     * Gets the status message. Empty string if no status message given.
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Returns the Status of the test :
     * STATUS_FAILED = 0
     * STATUS_OK = 1
     * STATUS_UNKNOWN = 2
     * @return int - Constants defined in QUI\Requirements\Testresult
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns a human readable (localized) status.
     */
    public function getStatusHumanReadable()
    {
        switch ($this->status) {
            case self::STATUS_FAILED:
                return "FAILED";
                #return \QUI::getLocale()->get('quiqqer/requirements', 'requirements.status.failed');
                break;
            case self::STATUS_OK:
                return "OK";
                #return \QUI::getLocale()->get('quiqqer/requirements', 'requirements.status.ok');
                break;
            case self::STATUS_UNKNOWN:
                return "UNKNOWN";
                #return \QUI::getLocale()->get('quiqqer/requirements', 'requirements.status.unknown');
                break;
        }
    }
}
