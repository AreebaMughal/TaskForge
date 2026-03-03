<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    protected $fillable = ['minutes', 'note', 'task_id', 'created_by'];

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks(){
        return $this->belongsTo(Task::class);
    }
}
