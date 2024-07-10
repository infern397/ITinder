<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $with = ['skills', 'seekingSkills'];

    protected $attributes = [
        'bio' => '',
        'experience' => ''
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'bio',
        'location',
        'experience',
        'github_link',
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

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function seekingSkills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_seeking_skills');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function userMatches()
    {
        return $this->hasMany(UserMatch::class);
    }

    public function matchedUsers()
    {
        return $this->belongsToMany(User::class, 'user_matches', 'user_id', 'matched_user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function getSkillsIdsAttribute()
    {
        return $this->skills ? $this->skills->pluck('id')->toArray() : [];
    }

    public function getSeekingSkillsIdsAttribute()
    {
        return $this->seeking_skills ? $this->seeking_skills->pluck('id')->toArray() : [];
    }
}
