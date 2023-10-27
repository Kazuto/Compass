<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookmarkGroup> $bookmarkGroups
 * @property-read int|null $bookmark_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $whitelistAccess
 * @property-read int|null $whitelist_access_count
 *
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static Builder|Team isMember(\App\Models\User $user)
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team onlyTrashed()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereDeletedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team whereUuid($value)
 * @method static Builder|Team withTrashed()
 * @method static Builder|Team withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Team extends Model
{
    //region Traits
    use HasFactory;
    use SoftDeletes;
    //endregion Traits

    //region Constants
    //endregion Constants

    //region ORM
    protected $table = 'teams';

    protected $fillable = [
        'name',
        'uuid',
    ];

    protected static function boot()
    {
        self::creating(function (Team $model) {
            $model->uuid = Str::uuid();
        });

        parent::boot();
    }

    //endregion ORM

    //region Relations
    public function bookmarkGroups(): BelongsToMany
    {
        return $this->belongsToMany(
            BookmarkGroup::class,
            'bookmark_group_team',
            'team_id',
            'bookmark_group_id',
            'id',
            'id'
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'team_user',
            'user_id',
            'team_id',
            'id',
            'id'
        );
    }

    public function whitelistAccess(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'team_whitelist_access',
            'team_id',
            'whitelist_access_id',
            'id',
            'id'
        );
    }
    //endregion Relations

    //region Scopes
    public function scopeIsMember(Builder $builder, User $user): Builder
    {
        return $builder->whereHas('users', function (Builder $builder) use ($user) {
            $builder->where('id', '=', $user->id);
        });
    }
    //endregion Scopes

    //region Methods
    //endregion Methods
}
