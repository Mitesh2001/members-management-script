<?php

namespace App\Models;

use App\Notifications\AdminResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = ['name', 'email', 'password', 'username'];

    /**
    *
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Send the password reset notification.
     *
     * @param string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
}
