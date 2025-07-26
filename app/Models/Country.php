<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    // Specify the table name
    protected $table = 'countries';

    // Specify the primary key
    protected $primaryKey = 'countryId';

    // Define fillable fields for mass assignment
    protected $fillable = ['uid', 'name', 'code'];

    public function states()
    {
        return $this->hasMany(City::class, 'countryId', 'uid');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'countryId', 'uid');
    }
}
