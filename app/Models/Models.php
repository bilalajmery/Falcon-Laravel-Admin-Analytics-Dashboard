<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'modelId';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'uid',
        'makeId',
        'name',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function make()
    {
        return $this->belongsTo(Make::class, 'makeId', 'uid');
    }
}
