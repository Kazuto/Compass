<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use function config;

/**
 * App\Models\Settings\AccessWhitelist
 *
 * @property int $id
 * @property string $email
 * @property int $is_available
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 *
 * @method static Builder|WhitelistAccess available()
 * @method static Builder|WhitelistAccess forEmail(string $email)
 * @method static Builder|WhitelistAccess newModelQuery()
 * @method static Builder|WhitelistAccess newQuery()
 * @method static Builder|WhitelistAccess onlyTrashed()
 * @method static Builder|WhitelistAccess query()
 * @method static Builder|WhitelistAccess unavailable()
 * @method static Builder|WhitelistAccess whereCreatedAt($value)
 * @method static Builder|WhitelistAccess whereDeletedAt($value)
 * @method static Builder|WhitelistAccess whereEmail($value)
 * @method static Builder|WhitelistAccess whereId($value)
 * @method static Builder|WhitelistAccess whereIsAvailable($value)
 * @method static Builder|WhitelistAccess whereUpdatedAt($value)
 * @method static Builder|WhitelistAccess whereUserId($value)
 * @method static Builder|WhitelistAccess withTrashed()
 * @method static Builder|WhitelistAccess withoutTrashed()
 *
 * @mixin \Eloquent
 */
class WhitelistAccess extends Model
{
    //region Traits
    use HasFactory;
    use SoftDeletes;
    //endregion Traits

    //region Constants
    //endregion Constants

    //region ORM
    protected $table = 'whitelist_access';

    protected $fillable = [
        'email',
        'is_available',
        'user_id',
    ];
    //endregion ORM

    //region Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    //endregion Relations

    //region Scopes
    public function scopeForEmail(Builder $builder, string $email): Builder
    {
        return $builder->where('email', '=', $email)->available();
    }

    public function scopeAvailable(Builder $builder): Builder
    {
        return $builder->where('is_available', '=', true);
    }

    public function scopeUnavailable(Builder $builder): Builder
    {
        return $builder->where('is_available', '=', 'false');
    }
    //endregion Scopes

    //region Methods
    public static function isWhitelisted(string $email): bool
    {
        if (config('compass.auth.whitelist_admin_email') === $email) {
            return true;
        }

        return static::forEmail($email)->exists();
    }

    public static function isNotWhitelisted(string $email): bool
    {
        return ! static::isWhitelisted($email);
    }
    //endregion Methods
}
