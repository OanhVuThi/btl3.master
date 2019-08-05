<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'active', 'remember_token', 'email_verified_at'
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
     * The attributes that should be cast to nativfe types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUpdate($id, $name)
    {
        $user = $this->find($id);
        $user->name = $name;
        $user->save();
        return $user;
    }
    public function depots()
    {
        return $this->hasMany('App\Depot');
    }


    public function products()
    {
        return $this->hasManyThrough('App\Product', 'App\Depot');
    }

    public function getUsers()
    {
        $users = self::with('depots')->get();
        return $users;
    }
    public function getUserbyID($id)
    {
        $user = self::findOrFail($id);
        return $user;
    }
    public function insertUser($name, $email, $password)
    {
        $users = self::create([
            'name' => $name,
            'password' => bcrypt($password),
            'email' => $email,
            'remember_token' => str_random(10),
            'email_verified_at' => now()
        ]);
        return $users;
    }
    public function deleteUser($id)
    {
        $user = self::findOrFail($id);
        $user->delete();
        return $user;
    }
}
