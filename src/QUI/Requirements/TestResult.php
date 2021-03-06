<?php

namespace QUI\Requirements;

/**
 * Class TestResult
 *
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
     * @var string - The status message which should be displayed on the console.
     */
    protected $consoleMessage;
    
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
     * Test created a warning. QUIQQER will run, but further steps are recommended
     */
    const STATUS_WARNING = 3;

    /**
     * Test created a warning. QUIQQER will run, but further steps are recommended
     */
    const STATUS_OPTIONAL = 4;

    /**
     * TestResult constructor.
     * STATUS_FAILED = 0
     * STATUS_OK = 1
     * STATUS_UNKNOWN = 2
     * STATUS_WARNING = 3
     * STATUS_OPTIONAL = 4
     *
     * @param int $status - Constants defined in QUI\Requirements\Testresult
     * @param string $message - (optional) Status message.
     * @param string $consoleMessage - (optional) A special message which should be displayed on the console
     */
    public function __construct($status, $message = "", $consoleMessage = "")
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Gets the status message. Empty string if no status message given.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Returns the message in plain text (without HTML and PHp Tags)
     *
     * @return string
     */
    public function getMessageRaw()
    {
        $message = str_replace(["<br />", "<br/>", "<br>"], PHP_EOL, $this->getMessage());
        $message = preg_replace('#<a.*?>.*?</a>#i', '', $message);
        $message = strip_tags($message);
        $message = trim($message);

        return $message;
    }

    /**
     * @return string
     */
    public function getMessageConsole()
    {
        if (!empty($this->consoleMessage)) {
            return $this->consoleMessage;
        }
        
        $message = str_replace(["<br />", "<br/>", "<br>"], PHP_EOL, $this->getMessage());
        $message = preg_replace('#<a.*?>.*?</a>#i', '', $message);
        
        $message = strip_tags($message);
        $message = trim($message);

        return $message;
    }

    /**
     * Returns the Status of the test :
     * STATUS_FAILED = 0
     * STATUS_OK = 1
     * STATUS_UNKNOWN = 2
     *
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
                return Locale::getInstance()->get('requirements.status.failed');
                break;
            case self::STATUS_OK:
                return Locale::getInstance()->get('requirements.status.ok');
                break;
            case self::STATUS_UNKNOWN:
                return Locale::getInstance()->get('requirements.status.unknown');
                break;
            case self::STATUS_WARNING:
                return Locale::getInstance()->get('requirements.status.warning');
                break;
            case self::STATUS_OPTIONAL:
                return Locale::getInstance()->get('requirements.status.optional');
                break;
            default:
                return Locale::getInstance()->get('requirements.status.unknown');
                break;
        }
    }
}
