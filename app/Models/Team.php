<?php

declare(strict_types=1);

namespace App\Models;

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
 *
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Team withoutTrashed()
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
            'team_id',
            'user_id',
            'id',
            'id'
        );
    }
    //endregion Relations

    //region Scopes
    //endregion Scopes

    //region Methods
    //endregion Methods
}
