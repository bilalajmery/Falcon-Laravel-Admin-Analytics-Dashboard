<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'subCategoryId';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'uid',
        'categoryId',
        'name',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'uid');
    }
}
