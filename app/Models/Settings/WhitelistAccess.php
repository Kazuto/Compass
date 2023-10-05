<?php

declare(strict_types=1);

namespace App\Models\Settings;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

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
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess available()
 * @method static \Database\Factories\Settings\WhitelistAccessFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess unavailable()
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WhitelistAccess withoutTrashed()
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
    //endregion Methods
}
