<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeNilai extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'attribute_nilai';

    //public $incrementing = false;

    protected $fillable = ['nilai_atribut', 'attribute_id'];

    protected $dates = [];

    /**
     * Get the attribute that owns the AttributeNilai
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get all of the dataSetDetail for the AttributeNilai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSetDetail()
    {
        return $this->hasMany(DataSetDetail::class);
    }

    /**
     * Get all of the dataLatih for the AttributeNilai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataLatih()
    {
        return $this->belongsTo(DataLatih::class);
    }
}
