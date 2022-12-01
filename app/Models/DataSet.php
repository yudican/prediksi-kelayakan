<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSet extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_set';
    //public $incrementing = false;

    protected $fillable = ['kode'];

    protected $dates = [];

    /**
     * Get all of the dataSetDetail for the DataSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSetDetail()
    {
        return $this->hasMany(DataSetDetail::class);
    }
}
