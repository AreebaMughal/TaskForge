<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    use HasFactory;
    protected $fillable = ['minutes', 'note', 'task_id', 'created_by'];

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
