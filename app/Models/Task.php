<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status', 'due_date', 'project_id', 'created_by'];
    
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function timelogs(){
        return $this->hasMany(Timelog::class);
    }
}
