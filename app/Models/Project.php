<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function partner() : HasOne
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }
}
