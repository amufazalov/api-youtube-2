<?php
namespace App\Base;

class Controller{

    /**
     * @var
     */
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}