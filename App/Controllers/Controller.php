<?php

namespace App\Controllers;

use Core\Session;

class Controller
{

    public function __construct()
    {
        Session::startSession();
    }
}
