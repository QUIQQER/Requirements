<?php

namespace QUI\Requirements;

class TestResult
{

    private $status;
    private $message;

    const STATUS_FAILED = 0;
    const STATUS_OK = 1;
    const STATUS_UNKNOWN = 2;

    public function __construct($status, $message = "")
    {
        $this->status  = $status;
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStatusHumanReadable(){
        switch($this->status){
            case self::STATUS_FAILED:
                \QUI::getLocale()->get('quiqqer/requirements','requirements.status.failed');
                break;
            case self::STATUS_OK:
                \QUI::getLocale()->get('quiqqer/requirements','requirements.status.ok');
                break;
            case self::STATUS_UNKNOWN:
                \QUI::getLocale()->get('quiqqer/requirements','requirements.status.unknown');
                break;
        }
    }

}