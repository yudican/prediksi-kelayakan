<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSetDetail extends Model
{
    use HasFactory;
    protected $table = 'data_set_detail';
    protected $fillable = ['data_set_id', 'attribute_nilai_id'];

    /**
     * Get the dataSet that owns the DataSetDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataSet()
    {
        return $this->belongsTo(DataSet::class);
    }

    /**
     * Get the attributeNilai that owns the DataSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributeNilai()
    {
        return $this->belongsTo(AttributeNilai::class, 'attribute_nilai_id');
    }
}
