<?php

/**
 * Class Studioforty9_Recaptcha_Model_Counter
 */
class Studioforty9_Recaptcha_Model_Counter {

    /**
     * @var int
     */
    protected $count = 0;

    /**
     *
     */
    public function increase()
    {
        $this->count++;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
}