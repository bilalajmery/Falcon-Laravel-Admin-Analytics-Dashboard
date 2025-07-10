<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubType extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'subTypeId';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'uid',
        'typeId',
        'name',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'typeId', 'uid');
    }
}
