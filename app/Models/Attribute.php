<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['nama_atribut', 'status'];

    protected $dates = [];

    /**
     * Get all of the attributeNilai for the Attribute
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeNilai()
    {
        return $this->hasMany(AttributeNilai::class);
    }
}
