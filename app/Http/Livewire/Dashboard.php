<?php

namespace App\Http\Livewire;

use App\Http\Livewire\CoreComponent;
use Algorithm\C45;
use App\Http\Controllers\Mining\MainController;
use App\Models\Attribute;
use App\Models\AttributeNilai;
use App\Models\DataSet;
use App\Models\DataSetDetail;

class Dashboard extends CoreComponent
{


    public function render()
    {
        return view('livewire.dashboard');
    }
}
