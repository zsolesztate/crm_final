<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function coworkers()
    {
        return $this->belongsToMany(CoWorker::class, 'co_workers_partners');
    }
}
