<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Partner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_partners');
    }

    public function contacts() : HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function primary_contact() : HasOne
    {
        return $this->hasOne(Contact::class)->where('primary_contact', true);
    }

    public function project() : BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
