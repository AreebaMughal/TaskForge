<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'status', 'due_date', 'start_date', 'client_id', 'created_by'];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function task(){
        return $this->hasMany(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
