<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'status', 'due_date', 'start_date', 'client_id', 'created_by'];
    protected $casts = [
        'start_date'=>'date',
        'due_date' => 'date',
        'archived_at' => 'datetime',
    ];
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function members(){
        return $this->belongsToMany(User::class, 'user_projects')->withTimestamps();
    }
}
