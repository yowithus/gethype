<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Mail;
use App\Mail\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'gender', 'birthdate', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->queue(new ResetPassword($token));
    }

    /**
     * Get the photo for the user.
     */
    public function photo()
     {
        $filename = md5('user-' . $this->id) . '.jpg';
        if (file_exists(public_path() . '/images/users/'. $filename)) {
            return $filename;
        } else {
            return 'default.png';
        }     
     }

    /**
     * Get the events for the user.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class)->where('order_status', 2);
    }

    /**
     * Get the interests for the user.
     */
    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    /**
     * Get the bookmarks for the user.
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
