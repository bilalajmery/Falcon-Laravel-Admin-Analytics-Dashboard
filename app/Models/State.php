<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, SoftDeletes;

    // Specify the table name
    protected $table = 'states';

    // Specify the primary key
    protected $primaryKey = 'stateId';

    // Define fillable fields for mass assignment
    protected $fillable = ['uid', 'countryId', 'name', 'code'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId', 'uid');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'stateId', 'uid');
    }
}
