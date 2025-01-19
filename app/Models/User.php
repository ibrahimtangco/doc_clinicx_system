<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomEmailVerificationNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile',
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'email',
        'userType',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    public function provider()
    {
        return $this->hasOne(Provider::class, 'user_id', 'id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFullNameAttribute()
    {
        $firstName = $this->first_name;
        $middleName = $this->middle_name;
        $lastName = $this->last_name;

        if ($middleName) {
            $middleInitial = ucfirst(substr($middleName, 0, 1));
            return "$firstName $middleInitial. $lastName";
        } else {
            return "$firstName $lastName";
        }
    }

    public function getInitialAttribute()
    {
        $firstInitial = strtoupper(substr($this->first_name, 0, 1));
        $lastInitial = strtoupper(substr($this->last_name, 0, 1));

        return "$firstInitial$lastInitial";
    }


    public function storeUserDetails($validated, $address)
    {
        return User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'address' => $address,
            'email' => $validated['email'],
            'userType' => $validated['userType'],
            'password' => Hash::make($validated['password']),
        ]);
    }

    public function updateUserDetails($validated, $address, $user_id)
    {
        $userToUpdate = User::findOrFail($user_id);

        return $userToUpdate->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'address' => $address,
            'email' => $validated['email'],
        ]);
    }
}
