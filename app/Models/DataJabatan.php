<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJabatan extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_jabatan';

    //public $incrementing = false;

    protected $fillable = ['nama_jabatan'];

    protected $dates = [];
}
