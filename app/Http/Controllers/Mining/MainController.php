<?php

namespace App\Http\Controllers\Mining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Algorithm\C45;

class MainController extends C45
{
    /**
     * Load file
     * 
     * @param  string $file
     * @return Algorithm\C45
     */
    public function loadFile($data = [])
    {
        $this->c45 = new InputDataController($data);
        return $this;
    }
}
