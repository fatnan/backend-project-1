<?php

namespace App\Models;

class Yacht extends Ship
{
    protected $luxuryLevel;

    public function __construct($name, $weight, $luxuryLevel)
    {
        parent::__construct($name, $weight);
        $this->luxuryLevel = $luxuryLevel;
    }

    public function getLuxuryLevel()
    {
        return $this->luxuryLevel;
    }

    public function getType()
    {
        return 'Yacht';
    }
}
