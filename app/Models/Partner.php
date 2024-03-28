<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_partners');
    }
}
