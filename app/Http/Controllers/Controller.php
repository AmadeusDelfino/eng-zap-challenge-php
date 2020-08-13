<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use RuntimeException;

class Controller extends BaseController
{
    protected $service;

    public function __construct()
    {
        if(!class_exists($this->service)) {
            throw new RuntimeException('The service '. $this->service .' does not exist');
        }

        $this->service = new $this->service;
    }
}
