<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'adminId';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'uid',
        'name',
        'email',
        'phone',
        'otp',
        'verified',
        'status',
        'password',
        'profile',
        'twoStepVerification'
    ];

    protected $hidden = [
        'password',
        'otp',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'status' => 'boolean',
    ];
}
