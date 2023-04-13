<?php

namespace App\Models;

abstract class Ship
{
    protected $name;
    protected $weight;
    protected $length;
    protected $width;

    public function __construct($name, $weight)
    {
        $this->name = $name;
        $this->weight = $weight;
    }

    public function getName()
    {
        return "Name : ".$this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    abstract public function getType();
}
