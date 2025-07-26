<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    // Specify the table name
    protected $table = 'cities';

    // Specify the primary key
    protected $primaryKey = 'cityId';

    // Define fillable fields for mass assignment
    protected $fillable = ['uid', 'name', 'countryId', 'stateId'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId', 'uid');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'stateId', 'uid');
    }
}
