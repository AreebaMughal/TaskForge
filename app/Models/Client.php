<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'contact_email', 'created_by'];
    public function projects(){
        return $this->hasMany(Project::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
