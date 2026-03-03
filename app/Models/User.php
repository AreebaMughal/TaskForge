<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function clients(){
        return $this->hasMany(Client::class, 'created_by');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'created_by');
    }

    public function timelogs(){
        return $this->hasMany(Timelog::class, 'created_by');
    }
    
    public function projects(){
        return $this->belongsToMany(Project::class, 'user_projects')->withTimestamps();
    }

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function isManager(){
        return $this->role === 'manager';
    }

    public function isMember(){
        return $this->role === 'member';
    }
}
