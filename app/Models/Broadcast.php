<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $fillable = [

        'target',
        'message',
        'total',
        'success',
        'failed',
        'status',
        'admin_id',
        'started_at',
        'finished_at',

    ];

    public function admin()
    {
        return $this->belongsTo(User::class,'admin_id');
    }
}
