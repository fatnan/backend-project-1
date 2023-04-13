<?php

namespace App\Models;

class MotorBoat extends Ship
{
    protected $fuelType;

    public function __construct($name, $weight, $fuelType)
    {
        parent::__construct($name, $weight);
        $this->fuelType = $fuelType;
    }

    public function getFuelType()
    {
        return $this->fuelType;
    }

    public function getType()
    {
        return 'Motor Boat';
    }

    // public function getName()
}
