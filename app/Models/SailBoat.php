<?php

namespace App\Models;

class SailBoat extends Ship
{
    protected $mastHeight;

    public function __construct($name, $weight, $mastHeight)
    {
        parent::__construct($name, $weight);
        $this->mastHeight = $mastHeight;
    }

    public function getMastHeight()
    {
        return $this->mastHeight;
    }

    public function getType()
    {
        return 'Sail Boat';
    }
}
