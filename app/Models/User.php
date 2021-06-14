<?php

namespace App\Models;

use App\Events\UserSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    public const GENDER_PREFIX_MAP = [
        'Mr.' => 'Male',
        'Mrs.' => 'Female',
        'Ms.' => 'Female',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'middlename',
        'password',
        'photo',
        'prefixname',
        'suffixname',
        'type',
        'username',
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

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }

    public function getFullnameAttribute(): string
    {
        return collect([
            $this->firstname,
            $this->middleinitial,
            $this->lastname,
            $this->suffixname,
        ])->filter()->join(' ');
    }

    public function getMiddleinitialAttribute(): string
    {
        return $this->middlename ? strtoupper($this->middlename[0]) . '.' : '';
    }

    public function getGenderAttribute(): string
    {
        return self::GENDER_PREFIX_MAP[$this->prefixname] ?? '';
    }
}
