<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BladeUI\Icons\Svg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $username
 * @property string $email
 * @property mixed|null $password
 * @property string|null $remember_token
 * @property string|null $oauth_provider
 * @property string|null $oauth_id
 * @property string|null $oauth_token
 * @property string|null $oauth_refresh_token
 * @property bool $is_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\WhitelistAccess|null $whitelistAccess
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOauthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOauthProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOauthRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOauthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    //region Traits
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    //endregion Traits

    //region Constants
    //endregion Constants

    //region ORM
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'oauth_provider',
        'oauth_id',
        'oauth_token',
        'oauth_refresh_token',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    protected static function boot()
    {
        self::creating(function (User $model) {
            $model->uuid = Str::uuid();
        });

        parent::boot();
    }

    //endregion ORM

    //region Relations
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'team_user',
            'user_id',
            'team_id',
            'id',
            'id'
        );
    }

    public function whitelistAccess(): HasOne
    {
        return $this->hasOne(WhitelistAccess::class, 'user_id', 'id');
    }
    //endregion Relations

    //region Scopes
    //endregion Scopes

    //region Methods
    public function getAuthProviderIcon(): Svg
    {
        return match ($this->oauth_provider) {
            'github' => svg('fab-github', ['class' => 'h-4 w-4', 'title' => 'GitHub OAuth']),
            'microsoft' => svg('fab-microsoft', ['class' => 'h-4 w-4', 'title' => 'Microsoft OAuth']),
            'azure' => svg('devicon-azure', ['class' => 'h-4 w-4', 'title' => 'Azure OAuth']),
            'google' => svg('fab-google', ['class' => 'h-4 w-4', 'title' => 'Google OAuth']),
            default => svg('phosphor-password', ['class' => 'h-4 w-4', 'title' => 'Basic Auth (Password)']),
        };
    }
    //endregion Methods
}
