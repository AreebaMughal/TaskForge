<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
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

    public function timelogs()
    {
        return $this->hasManyThrough(Timelog::class, Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
