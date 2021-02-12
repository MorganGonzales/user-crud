<?php

namespace App\Models;

use App\Events\UserSaved;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'password',
        'photo',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
    ];

    private static array $genderPrefixMap = [
        'Mr.' => 'Male',
        'Mrs.' => 'Female',
        'Ms.' => 'Female',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }

    public function getAvatarAttribute()
    {
        return $this->photo;
    }

    public function getFullnameAttribute(): string
    {
        $data = [
            $this->firstname,
            $this->middleinitial,
            $this->lastname,
            $this->suffixname,
        ];

        return implode(' ', \array_filter($data));
    }

    public function getMiddleinitialAttribute(): string
    {
        return $this->middlename ? strtoupper($this->middlename[0]) . '.' : '';
    }

    public function getGenderAttribute(): string
    {
        return self::$genderPrefixMap[$this->prefixname] ?? '';
    }
}
