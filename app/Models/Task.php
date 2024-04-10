<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tasks_users');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }
}
