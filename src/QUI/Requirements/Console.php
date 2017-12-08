<?php

namespace QUI\Requirements;

use QUI\Requirements\Tests\Quiqqer\Checksums;
use QUI\System\Console\Tool;

class Console extends Tool
{
    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->setName('requirements:integrity')
            ->setDescription('Checks the integrity of the installed packages');
    }

    /**
     * 
     */
    public function execute()
    {
        $Test = new Checksums();
        $TestResult = $Test->getResult();
        
        if($TestResult->getStatus() == TestResult::STATUS_OK){
            $this->writeLn("All packages have passed the integrity check.","green");
            return;
        }

        $message  = $TestResult->getMessage();
        $message = str_replace("</span>",PHP_EOL,$message);
        $message = strip_tags($message);
        
        $this->writeLn("Some packages have modified files. Please check the following packages:","red");
        $this->writeLn($message);
        
    }
}