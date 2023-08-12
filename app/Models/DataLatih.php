<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLatih extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_latih';
    //public $incrementing = false;


    protected $fillable = ['data_nasabah_id', 'attribute_nilai_id'];

    protected $dates = [];

    /**
     * Get the attributeNilai that owns the DataSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributeNilai()
    {
        return $this->belongsTo(AttributeNilai::class, 'attribute_nilai_id');
    }

    /**
     * Get the dataNasabah that owns the DataLatih
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataNasabah()
    {
        return $this->belongsTo(DataNasabah::class, 'data_nasabah_id');
    }
}
