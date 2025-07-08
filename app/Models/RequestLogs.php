<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestLogs extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'request_logs';

    protected $primaryKey = 'requestLogsId';
    public $incrementing = true; // Auto-incrementing primary key
    protected $keyType = 'int';

    protected $fillable = ['ipAddress', 'endPoint', 'method', 'status', 'responseTime', 'portal']; // Include galleryId and adminId

    public $timestamps = true;
}
