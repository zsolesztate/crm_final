<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
