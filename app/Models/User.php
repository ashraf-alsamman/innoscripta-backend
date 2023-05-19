<?php
namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable , HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_user', 'user_id', 'category_id');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_user', 'user_id', 'author_id');
    }

    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class, 'source_user', 'user_id', 'source_id');
    }
}
